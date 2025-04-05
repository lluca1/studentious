<?php

namespace App\Livewire\Curricula;

use Livewire\Component;
use App\Models\Curriculum;

class CurriculumCard extends Component
{
    public Curriculum $curriculum;

    public function mount(Curriculum $curriculum)
    {
        $this->curriculum = $curriculum;
    }

    public function render()
    {
        return view('livewire.curricula.curriculum-card');
    }
}
