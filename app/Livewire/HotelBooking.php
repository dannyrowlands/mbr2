<?php

namespace App\Livewire;

use App\Models\Hotel;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
    #[Rule('required', message:'Please let us know how many nights you wish to stay.')]
    public $nights = null;
    #[Rule('required', message:'Please tell us how many rooms you need.')]
    public $number_of_rooms = 1;
    #[Rule('required', message:'Please tell us how many people will be staying.')]
    public $number_of_pax = 1;
    public $notes = '';
    public $chosen_datas = [];
    public $total_cost = 0;


    public function render()
    {
        $this->hotels = Hotel::all();
        return view('livewire.hotel-booking');
    }

    public function setRoomTypes()
    {
        $this->room_types = RoomType::where('hotel_id', '=', $this->hotel)->get();
    }

    public function setNumNights()
    {
        $start = new Carbon($this->start);
        $end = new Carbon($this->end);
        $this->nights = $start->diffInDays($end);
    }

    public function getTableData()
    {
        if(
            $this->hotel != '' &&
            $this->room_type != '' &&
            $this->start != ''&&
            $this->nights != '' &&
            $this->number_of_pax != ''
        )
        {
            $this->chosen_datas = [];
            $start = new Carbon($this->start);
            $end = new Carbon($this->end);
            $end->subDay();

            $cost = RoomType::
            where('hotel_id', '=', $this->hotel)
                ->where('type', '=', $this->room_type)
                ->first()->cost;

            foreach(CarbonPeriod::create($start, $end) as $date)
            {
                $details = $this->number_of_rooms.' room * '.$cost.' USD';
                $this->chosen_datas[] = [
                    'date' => $date,
                    'details' => $details,
                    'daily_cost' => $cost*$this->number_of_rooms.' USD',
                ];
            }
            $this->total_cost = $cost*$this->number_of_rooms*$this->nights;
        }
    }

    public function changeChosenDates()
    {
        $start_date = new Carbon($this->start);
        $this->end = $start_date->addDays($this->nights+1);
        $end_date = new Carbon($this->end);
        $this->dates = $start_date->format('D jS M Y') . ' to ' . $end_date->format('D jS M Y');
        $this->getTableData();
    }

    public function changeNumberPax()
    {
        if($this->number_of_pax > 1)
        {
            
        }
        $this->getTableData();
    }

    public function submit()
    {
        $this->validate();
        dd('Form Submitted');
    }
}
