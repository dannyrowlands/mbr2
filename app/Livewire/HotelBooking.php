<?php

namespace App\Livewire;

use App\Models\Hotel;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Rule;

class HotelBooking extends Component
{
    public $hotels = [];
    public $room_types = [];

    #[Rule('required', message:'Which hotel woud you like to stay at?')]
    public $hotel = null;
    #[Rule('required', message:'Please choose your Room.')]
    public $room_type = null;
    #[Rule('required', message:'Please let us know when you wish to stay.')]
    public $dates = '';
    public $start = '';
    public $end = "";
    public $days = null;
    #[Rule('required|numeric|min:1|max:6', message:'Please let us know how many nights you wish to stay.')]
    public $nights = null;
    #[Rule('required|numeric|min:1|max:2', message:'Please tell us how many rooms you need.')]
    public $number_of_rooms = 1;
    #[Rule('required|numeric|min:1|max:5', message:'Please tell us how many people will be staying.')]
    public $number_of_pax = 1;
    #[Rule('required_unless:number_of_pax,1', message:'Please add notes.')]
    public $notes = '';
    public $chosen_datas = [];
    public $total_cost = 0;
    public $show_notes_validation = false;
    public $show_data_table = false;


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        $this->hotels = Hotel::all();
        return view('livewire.hotel-booking');
    }

    /**
     * @return void
     */
    public function setRoomTypes()
    {
        $this->room_type = null;
        $this->room_types = RoomType::where('hotel_id', '=', $this->hotel)->get();
        $this->getTableData();
    }

    /**
     * @return void
     */
    public function setNumNights()
    {
        $this->resetValidation('nights');
        $start = new Carbon($this->start);
        $end = new Carbon($this->end);
        $this->nights = $start->diffInDays($end);
        $this->days = $start->diffInDays($end)+1;
    }

    /**
     * @return void
     */
    public function getTableData()
    {
        $this->show_data_table = false;
        if(
            $this->hotel != '' &&
            $this->room_type != '' &&
            $this->start != ''&&
            $this->nights != '' &&
            $this->number_of_pax != '' &&
            $this->nights > 0 &&
            $this->nights < 8
        )
        {
            $this->show_data_table = true;
            $this->chosen_datas = [];
            $start = new Carbon($this->start);
            $temp_start_date = new Carbon($this->start);
            $this->end = $temp_start_date->addDays($this->nights);

            $cost = RoomType::
            where('hotel_id', '=', $this->hotel)
                ->where('type', '=', $this->room_type)
                ->first()->cost;

            $increment = 1;
            foreach(CarbonPeriod::create($start, $this->end) as $date)
            {
                if ($increment <= $this->nights) {
                    $details = $this->number_of_rooms.' room * '.$cost.' USD';
                    $this->chosen_datas[] = [
                        'date' => $date,
                        'details' => $details,
                        'daily_cost' => number_format($cost*$this->number_of_rooms, 2).' USD',
                    ];
                }
                $increment++;
            }
            $this->total_cost = number_format($cost*$this->number_of_rooms*$this->nights, 2);
        }
    }

    /**
     * @return void
     */
    public function changeChosenDates()
    {
        $start_date = new Carbon($this->start);
        $temp_start_date = new Carbon($this->start);
        $this->end = $temp_start_date->addDays($this->nights);
        $end_date = new Carbon($this->end);
        $this->dates = $start_date->format('D jS M Y') . ' to ' . $end_date->format('D jS M Y');
        $this->getTableData();
    }

    /**
     * @return void
     */
    public function changeNumberPax()
    {
        $this->show_notes_validation = false;
        $this->resetValidation('notes');
        if($this->number_of_pax > 1) {
            $this->show_notes_validation = true;
        }
    }

    /**
     * @return void
     */
    public function submit()
    {
        $this->validate();
        dd('Form Submitted');
    }
}
