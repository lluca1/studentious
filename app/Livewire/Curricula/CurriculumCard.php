<?php

namespace App\Livewire\Curricula;

use Livewire\Component;
use App\Models\Curriculum;

class CurriculumCard extends Component
{
    public Curriculum $curriculum;
    public $generating = false;
    public $showAiContent = false;
    public $processingError = null;

    public function mount(Curriculum $curriculum)
    {
        $this->curriculum = $curriculum;
    }

    public function toggleAiContent()
    {
        $this->showAiContent = !$this->showAiContent;
    }

    public function generateAiContent()
    {
        if (!$this->curriculum->file_path) {
            $this->processingError = "No PDF file available to process";
            return;
        }

        $this->generating = true;
        $this->processingError = null;

        // redirect to the controller
        return redirect()->route('ai.generate', [
            'pdf_path' => $this->curriculum->file_path,
            'curriculum_id' => $this->curriculum->id
        ]);
    }

    public function render()
    {
        // refresh
        if ($this->generating) {
            $this->curriculum->refresh();
            $this->generating = !($this->curriculum->ai_summary && $this->curriculum->ai_audio_url);
        }

        return view('livewire.curricula.curriculum-card');
    }
}
