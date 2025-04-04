<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Curriculum;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEvent extends Component
{
    use WithFileUploads;
    
    public $title;
    public $description;
    public $start_time;
    public $end_time;
    
    public $curriculumTitle;
    public $curriculumDescription;
    public $curriculumFile;
    public $includeCurriculum = false;
    
    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'start_time' => 'required|date|after_or_equal:now',
        'end_time' => 'required|date|after:start_time',
        'curriculumTitle' => 'required_if:includeCurriculum,true',
        'curriculumDescription' => 'nullable',
        'curriculumFile' => 'required_if:includeCurriculum,true|file|mimes:pdf|max:10240', // 10MB max
    ];
    
    public function save()
    {
        $this->validate();
        
        $event = Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'creator_id' => auth()->id(),
        ]);
        
        if ($this->includeCurriculum && $this->curriculumFile) {
            $filePath = $this->curriculumFile->store('curricula', 'public');
            
            Curriculum::create([
                'title' => $this->curriculumTitle,
                'description' => $this->curriculumDescription ?? '',
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'file_path' => $filePath,
            ]);
        }
        
        session()->flash('message', 'Event created successfully!');
        
        return redirect()->route('events.index');
    }
    
    public function render()
    {
        return view('livewire.events.create-event');
    }
}