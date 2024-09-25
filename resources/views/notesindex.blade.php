@if ($errors->any())
    <div class="mb-4 p-2 bg-red-500 text-white rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end">
                        <button
                            style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;"
                            onclick="openModal()">
                            Add Note
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">All Notes</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach ($notes as $note)
                            <li class="p-4 bg-gray-100 rounded-md shadow flex justify-between items-center">
                                <div>
                                    <p>{{ $note->note }}</p>
                                    <span class="text-sm text-gray-600">{{ $note->created_at->format('Y-m-d H:i') }}</span>
                                </div>

                                <div class="flex space-x-4">
                                    <button type="button"
                                            class="text-white"
                                            onclick="updateModal('{{ $note->id }}', '{{ $note->note }}')"
                                            style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                                        Edit
                                    </button>

                                    <form action="{{ route('note.destroy', $note->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-white"
                                                style="background-color: #ff2d20; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>



    <div id="noteModal" style="display: none;" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div style="width: 70%; max-width: 1000px;" class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Add a New Note</h2>

            <form id="noteForm" action="{{ route('note.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Note</label>
                    <textarea id="note" required name="note" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Enter your note"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                    <button
                        type="submit"
                        style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                        Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Edit Note</h2>
            <form id="editNoteForm" action="" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" id="noteId" name="noteId">

                <div class="mb-4">
                    <label for="noteContent" class="block text-gray-700">Note</label>
                    <textarea id="noteContent" name="note" rows="4" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md"
                            style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('noteModal').style.display = 'flex';
        }

        function updateModal() {
            document.getElementById('noteModalUpdate').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('noteModal').style.display = 'none';
        }
    </script>

    <script>
        function updateModal(noteId, noteContent) {
            document.getElementById('editNoteForm').action = "{{ route('note.update', ':id') }}".replace(':id', noteId);

            document.getElementById('noteId').value = noteId;

            document.getElementById('noteContent').value = noteContent;

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>

</x-app-layout>
