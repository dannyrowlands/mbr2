<div class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">
<form>
    <div class="p-6 mx-auto max-w-7xl lg:p-8">
        <div class="grid grid-cols-2 gap-4">
            <div class="pt-4">
                <label for="hotel">Hotel *</label>
                <div>
                    <select
                        class="form-control w-96"
                        wire:model.live="hotel"
                    >

                        <option>-- Select Hotel --</option>

                        @foreach($hotels as $hotel)

                            <option
                                value="{{ $hotel->id }}"
                                wire:key="{{ $hotel->id }}"
                            >
                                {{ $hotel->name }}
                            </option>

                        @endforeach

                    </select>
                    <div class="text-red-600">
                        @error('hotel') <em>{{ $message }}</em>@enderror
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <label for="type">Room type *</label>
                <div>
                    <select
                        wire:model.live="room_type"
                        class="form-control w-96"
                    >

                        <option value="">-- Select Room Type --</option>

                        @foreach($room_types as $room_type)

                            <option wire:key="{{ $room_type->id }} value="{{ $room_type->id }}">{{ $room_type->type }}</option>

                        @endforeach

                    </select>
                    <div class="text-red-600">
                        @error('room_type') <em>{{ $message }}</em>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="pt-4">
                <label for="date">Dates *</label>
                <div>
                    <input
                        type="text"
                        size="41"
                        name="daterange"
                        id="daterange"
                        wire:model.live="dates"
                    />
                    <div class="text-red-600">
                        @error('dates') <em>{{ $message }}</em>@enderror
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <label for="nights">Number of nights *</label>
                <div>
                    <input
                        @if($start == '')
                            disabled
                        @endif
                        type="text"
                        size="41"
                        wire:model.live.debounce.750ms="nights"
                    />
                    <div class="text-red-600">
                        @error('nights') <em>{{ $message }}</em>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="pt-4">
                <label for="rooms">Number of rooms *</label>
                <div>
                    <select
                        class="form-control w-96"
                        wire:model.live="number_of_rooms"
                    >

                        <option value="">-- Select Number of Rooms --</option>

                        @for($c=1; $c<3; $c++)

                            <option wire:key="{{ $c }} value="{{ $c }}">{{ $c }}</option>

                        @endfor

                    </select>
                    <div class="text-red-600">
                        @error('number_of_rooms') <em>{{ $message }}</em>@enderror
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <label for="number-of-pax">Number of pax *</label>
                <div>
                    <select
                        class="form-control w-96"
                        name="numberOfPax"
                        wire:model.live="number_of_pax"
                    >

                        <option value="">-- Select Number of Pax --</option>

                        @for($c=1; $c<6; $c++)

                            <option wire:key="{{ $c }} value="{{ $c }}">{{ $c }}</option>

                        @endfor

                    </select>
                    <div class="text-red-600">
                        @error('number_of_pax') <em>{{ $message }}</em>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 pt-4">
            <label for="notes">
                Notes
                @if ($show_notes_validation)
                    <span>*</span>
                @endif
            </label>
            <div>
                <textarea
                    cols="87"
                    class="rounded-md"
                    wire:model.live="notes"
                ></textarea>
                <div class="text-red-600">
                    @error('notes') <em>{{ $message }}</em>@enderror
                </div>
            </div>
        </div>
        @if ($show_data_table)
            <div class="flex justify-center items-center">
                <table
                    class="table-fixed w-106 text-left text-gray-600 border-collapse border-2 border-gray-500"
                >
                    <thead>
                    <tr>
                        <th class="w-1/3 border border-gray-400  px-4 py-2">Date</th>
                        <th class="w-1/3  border border-gray-400  px-4 py-2">Details</th>
                        <th class="w-1/3  border border-gray-400  px-4 py-2">Daily Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($chosen_datas as $chosen_data)
                        <tr wire:key="">
                            <td class="border border-gray-400  px-4 py-2">{{ $chosen_data['date'] }}</td>
                            <td class="border border-gray-400  px-4 py-2">{{ $chosen_data['details'] }}</td>
                            <td class="border border-gray-400  px-4 py-2">{{ $chosen_data['daily_cost'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-1">
                <div class=" flex justify-center items-center font-bold">Total Cost :&nbsp;<span>{{ $total_cost }}</span>&nbsp;USD</div>
            </div>
        @endif

        <div class="grid grid-cols-1">
            <button
                wire:click="submit"
                type="button"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-5 rounded"
            >Book</button>
        </div>
    </div>
</form>
</div>

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'center',
            minDate: moment(),
            autoApply: true,
            autoUpdateInput: false,
            maxSpan: {
                "days": 7
            },
        }, function(start, end, label) {
            @this.start = start;
            @this.end = end;
            @this.dates = start.format('ddd Do MMM YYYY') + ' to ' + end.format('ddd Do MMM YYYY');
            @this.setNumNights();
            $('input[name="daterange"]').focus();
        })
    })
</script>
