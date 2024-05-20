@extends('layouts.app')

@section('content')

<form class="w-full" action="{{ route('pelanggaran.create') }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="siswa" class="mb-2 block font-semibold">Siswa</label>
        <select name="id_siswa" id="id_siswa" class="border rounded p-2 w-full js-example-basic-single">
            <option value="" disabled selected>Masukkan Siswa</option>
            @foreach ($siswa as $option)
                <option value="{{ $option->id }}" {{ old('id_siswa') == $option->id ? 'selected' : '' }}>
                    {{ $option->nama }}
                </option>
            @endforeach
        </select>
        @if($errors->has('id_siswa'))
            <span class="text-red-500">{{ $errors->first('id_siswa') }}</span>
        @endif
    </div>

    <div id="message" class="py-5 text-gray-500">Klik "Tambah Baris" untuk memulai.</div>
    
    <button type="button" id="addRowButton" onclick="addRow()" class="bg-sky-500 text-white rounded p-2 w-fit px-10">Tambah Baris</button>
    <table class="w-full border-collapse border-spacing-4 my-5">
        <thead>
            <tr>
                <th class="border py-2 px-4">Kriteria</th>
                <th class="border py-2 px-4">Jenis Pelanggaran</th>
                <th class="border py-2 w-fit"></th>
            </tr>
        </thead>
        <tbody id="dynamicRows">
        </tbody>
    </table>
    
    <button type="submit" class="bg-green-500 text-white rounded p-2 w-fit px-10">Simpan</button>
</form>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    // Embed the kriteria_pelanggaran data as JSON objects
    var kriteriaPelanggaran = @json($kriteria_pelanggaran);

    // Function to add a new row
    function addRow() {
        var dynamicRows = document.getElementById('dynamicRows');
        var message = document.getElementById('message');

        // Hide the message when a row is added
        if (message) {
            message.style.display = 'none';
        }

        var newRow = document.createElement('tr');

        // Create the first select cell for criteria
        var firstSelectCell = document.createElement('td');
        firstSelectCell.classList.add('border', 'py-2', 'px-4');
        var firstSelect = document.createElement('select');
        firstSelect.setAttribute('name', 'id_kriteria[]');
        firstSelect.classList.add('border', 'rounded', 'p-2', 'w-full');
        var firstOption = document.createElement('option');
        firstOption.setAttribute('value', '');
        firstOption.setAttribute('disabled', 'disabled');
        firstOption.setAttribute('selected', 'selected');
        firstOption.innerText = 'Masukkan Kriteria';
        firstSelect.appendChild(firstOption);

        // Populate the options for the first select
        kriteriaPelanggaran.forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option.id;
            opt.innerText = option.kriteria;
            firstSelect.appendChild(opt);
        });

        firstSelectCell.appendChild(firstSelect);
        newRow.appendChild(firstSelectCell);

        // Create the second select cell for jenis pelanggaran
        var secondSelectCell = document.createElement('td');
        secondSelectCell.classList.add('border', 'py-2', 'px-4');
        var secondSelect = document.createElement('select');
        secondSelect.setAttribute('name', 'id_jenis[]');
        secondSelect.classList.add('border', 'rounded', 'p-2', 'w-full');
        var secondOption = document.createElement('option');
        secondOption.setAttribute('value', '');
        secondOption.setAttribute('disabled', 'disabled');
        secondOption.setAttribute('selected', 'selected');
        secondOption.innerText = 'Pilih Jenis Pelanggaran';
        secondSelect.appendChild(secondOption);

        secondSelectCell.appendChild(secondSelect);
        newRow.appendChild(secondSelectCell);

        // Add event listener to the first select
        firstSelect.addEventListener('change', function() {
            updateJenisPelanggaranOptions(firstSelect, secondSelect);
            updateKriteriaOptions();
        });

        // Create the delete button cell
        var deleteButtonCell = document.createElement('td');
        deleteButtonCell.classList.add('border', 'py-2', 'px-4');
        var deleteButton = document.createElement('button');
        deleteButton.setAttribute('type', 'button');
        deleteButton.setAttribute('onclick', 'removeRow(this)');
        deleteButton.classList.add('bg-red-500', 'text-white', 'rounded', 'p-2');
        deleteButton.innerText = 'Delete';
        deleteButtonCell.appendChild(deleteButton);
        newRow.appendChild(deleteButtonCell);

        // Append the new row to the table
        dynamicRows.appendChild(newRow);

        // Update options for kriteria select elements
        updateKriteriaOptions();
    }

    // Function to update the jenis_pelanggaran options based on selected kriteria
    function updateJenisPelanggaranOptions(kriteriaSelect, jenisSelect) {
        if (!kriteriaSelect || !jenisSelect) {
            console.error('Missing select elements');
            return;
        }

        // Get the selected kriteria id
        var selectedKriteriaId = kriteriaSelect.value;

        // Clear previous options in the jenis select
        jenisSelect.innerHTML = '';

        // Add the default option
        var defaultOption = document.createElement('option');
        defaultOption.setAttribute('value', '');
        defaultOption.setAttribute('disabled', 'disabled');
        defaultOption.setAttribute('selected', 'selected');
        defaultOption.innerText = 'Pilih Jenis Pelanggaran';
        jenisSelect.appendChild(defaultOption);

        // Find the corresponding kriteria object
        var selectedKriteria = kriteriaPelanggaran.find(function(kriteria) {
            return kriteria.id == selectedKriteriaId;
        });

        // Add the new options based on selected kriteria
        if (selectedKriteria && selectedKriteria.jenis) {
            selectedKriteria.jenis.forEach(function(option) {
                var opt = document.createElement('option');
                opt.value = option.id;
                opt.innerText = option.jenis_pelanggaran;
                jenisSelect.appendChild(opt);
            });
        } else {
            console.error('No jenis pelanggaran found for the selected kriteria');
        }
    }

    // Function to update the kriteria options to prevent duplicates
    function updateKriteriaOptions() {
        var kriteriaSelects = document.querySelectorAll('select[name="id_kriteria[]"]');
        var selectedKriteriaIds = Array.from(kriteriaSelects).map(function(select) {
            return select.value;
        });
    }

    // Function to remove a row
    function removeRow(btn) {
        var row = btn.parentNode.parentNode;
        if (row) {
            row.parentNode.removeChild(row);
        } else {
            console.error('Row not found for the delete button');
        }

        // If no rows left, show the message again
        var dynamicRows = document.getElementById('dynamicRows');
        if (dynamicRows.children.length === 0) {
            var message = document.getElementById('message');
            if (message) {
                message.style.display = 'block';
            }
        }

        // Update options for kriteria select elements
        updateKriteriaOptions();
    }
</script>

@endsection
