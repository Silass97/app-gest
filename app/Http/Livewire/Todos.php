<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Todo;

class Todos extends Component
{
   public $todos, $title, $description, $todo_id;
    public $isOpen = 0;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->todos = Todo::all();
        return view('livewire.todos');
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->description = '';
        $this->todo_id = '';
    }
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
    
        Todo::updateOrCreate(['id' => $this->todo_id], [
            'title' => $this->title,
            'description' => $this->description
        ]);
   
        session()->flash('message', 
            $this->todo_id ? 'Todo Updated Successfully.' : 'Todo Created Successfully.');
   
        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $Todo = Todo::findOrFail($id);
        $this->todo_id = $id;
        $this->title = $Todo->title;
        $this->description = $Todo->description;
     
        $this->openModal();
    }
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array 
     */
    public function delete($id)
    {
        Todo::find($id)->delete();
        session()->flash('message', 'Todo Deleted Successfully.');
    }
}