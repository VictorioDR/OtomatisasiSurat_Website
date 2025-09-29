<?php
namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\GeneratedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function show(Template $template)
    {
        $template->load('formFields');
        // pastikan hanya yang public atau pemilik bisa akses
        if (! $template->is_public && Auth::id() !== $template->user_id) {
            abort(403);
        }
        return view('generate.show', compact('template'));
    }

    public function generate(Request $request, Template $template)
    {
        $template->load('formFields');

        // Validate required fields
        $rules = [];
        foreach ($template->formFields as $field) {
            if ($field->is_required) {
                $rules["fields.{$field->field_name}"] = 'required';
            }
        }
        $data = $request->validate($rules) + $request->input('fields', []);

        // Get path to .docx template file on disk 'public'
        $templatePath = Storage::disk('public')->path($template->file_path);
        if (! file_exists($templatePath)) {
            return back()->withErrors(['file' => 'Template file not found on server.']);
        }

        $tp = new TemplateProcessor($templatePath);

        // Replace placeholders. Note: placeholders in docx should be like ${field_name}
        foreach ($template->formFields as $field) {
            $key = $field->field_name;
            $value = $data[$key] ?? '';
            // TemplateProcessor expects 'key' without ${}
            $tp->setValue($key, $value);
        }

        // Save generated file
        $filename = 'generated_' . Str::slug($template->name) . '_' . time() . '.docx';
        $tempPath = storage_path('app/public/generated/' . $filename);
        // ensure dir exists
        Storage::disk('public')->makeDirectory('generated');
        $tp->saveAs($tempPath);

        // Save log to DB
        $doc = GeneratedDocument::create([
            'user_id' => Auth::id() ?? null,
            'template_id' => $template->id,
            'filled_data' => $data,
            'file_path' => 'generated/' . $filename,
        ]);

        // Download and delete after send (optional)
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function download(GeneratedDocument $record)
    {
        if (Storage::disk('public')->exists($record->file_path)) {
            return Storage::disk('public')->download($record->file_path);
        }

        abort(404, 'File tidak ditemukan.');
    }

}
