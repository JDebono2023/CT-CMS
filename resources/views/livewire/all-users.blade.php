<div>
    <div class="pb-6 px-6 bg-white shadow shadow-gray-400">
        <div class="flex justify-center">
            <x-client-logo />
        </div>

        <h1 class="mb-6 text-lg lg:text-2xl font-bold text-blue-6 text-center">
            User Administration
        </h1>

        <p class="mt-6 text-gray-600 leading-relaxed text-center text-sm lg:text-base">
            View all users in the database, each user's team, and delete users. </br> To remove a user from a team,
            navigate
            to
            that users team to proceed with removal. To fully delete a user from the database, click Delete User.
        </p>


    </div>
    <div class="p-6 lg:p-8 shadow shadow-gray-400 border border-gray-200  bg-gray-200">

        {{-- The data table --}}
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class=" overflow-hidden sm:rounded shadow-lg shadow-gray-400">
                        <table class=" w-full 0">
                            <thead>
                                <tr
                                    class="px-6 py-3 bg-gray-600 text-center text-[10px] xl:text-xs leading-4 font-black text-white uppercase tracking-wider">
                                    <th class=" px-2 md:px-6 text-left">
                                        Name</th>
                                    <th class="px-2 md:px-6 text-left">
                                        Email</th>
                                    {{-- <th class="px-6 text-left">
                                    Assigned Role(s)</th> --}}
                                    <th class="px-2 md:px-6 text-left">
                                        Assigned Team(s)</th>
                                    <th class="px-2 md:px-6 text-center">
                                        View Team
                                    </th>
                                    <th class="px-2 md:px-6 py-3 text-center">
                                        Delete User
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($allUsers->count())
                                    @foreach ($allUsers as $item)
                                        <tr
                                            class="text-[10px] xl:text-xs leading-4 font-medium text-blue-9 uppercase tracking-wider text-left">

                                            @if ($item->id == 1)
                                            @else
                                                <td class="px-2 md:px-6 py-2">{{ $item->name }}</td>
                                                <td class="px-2 md:px-6 py-2">{{ $item->email }}</td>
                                            @endif

                                            @if ($item->id == 1)
                                            @else
                                                @foreach ($item->allTeams() as $team)
                                                    <td class="px-2 md:px-6 text-left ">
                                                        {{ $team->name }}</td>
                                                @endforeach
                                            @endif

                                            @if ($item->id == 1)
                                            @else
                                                @foreach ($item->allTeams() as $team)
                                                    @if (!$team->personal_team)
                                                        <td class="px-2 md:px-6  text-center">
                                                            <div class="">
                                                                <button>
                                                                    <a href="{{ route('teams.show', $team->id) }}">
                                                                        <span class="material-symbols-outlined">
                                                                            move_item
                                                                        </span>
                                                                    </a>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    @elseif (!$team->team_id)
                                                        <td class="px-2 md:px-6 text-center">No Team Assigned</td>
                                                    @endif
                                                @endforeach
                                            @endif


                                            @if ($item->id == 1)
                                                {{-- <td class=""></td> --}}
                                            @else
                                                <td class="px-2 md:px-6 text-center">
                                                    <button
                                                        class="material-symbols-outlined  py-3 text-xl leading-4 font-medium text-blue-9 tracking-wider text-center  hover:text-blue-2 active:bg-blue-3 transition ease-in-out duration-150"
                                                        wire:click="deleteShowModal({{ $item->id }})">
                                                        delete
                                                    </button>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No Results Found
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <br />
                    @if ($links->links())
                        {{ $links->links() }}
                    @endif
                </div>
            </div>
        </div>



        {{-- The Delete Modal --}}
        <x-dialog-modal wire:model="modalConfirmDeleteVisible">
            <x-slot name="title">

                {{ __('Delete User: ') }}{{ $name }}

            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to permenantly delete this user? Deleting this user will remove the user from the database and any assigned teams.') }}
                {{ __('To remove a user from a team, please access the specific team settings, and remove the user. ') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete user') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
