@extends('layouts.app')

@section('content')

<form class="w-full" action="{{ route('pelanggaran.update', ['id' => $pelanggaran->id]) }}" method="POST">
    @csrf
    <div class="py-5">
        <label for="siswa" class="mb-2 block font-semibold">Siswa</label>
        <select name="id_siswa" id="id_siswa" class="border rounded p-2 w-full">
            <option value="" disabled selected>Masukkan Siswa</option>
            @foreach ($siswa as $option)
                <option value="{{ $option->id }}" {{ old('id_siswa', $pelanggaran->id_siswa) == $option->id ? 'selected' : '' }}>
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
            <!-- Populate existing data if available -->
            @foreach ($pelanggaran->listPelanggaran as $list)
                <tr>
                    <td class="border py-2 px-4">
                        <select name="id_kriteria[]" class="border rounded p-2 w-full" onchange="updateJenisPelanggaranOptions(this, this.parentNode.nextElementSibling.children[0])">
                            <option value="" disabled selected>Masukkan Kriteria</option>
                            @foreach ($kriteria_pelanggaran as $option)
                                <option value="{{ $option->id }}" {{ old('id_kriteria', $list->id_kriteria) == $option->id ? 'selected' : '' }}>
                                    {{ $option->kriteria }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border py-2 px-4">
                        <select name="id_jenis[]" class="border rounded p-2 w-full">
                            <option value="" disabled selected>Pilih Jenis Pelanggaran</option>
                            @foreach ($kriteria_pelanggaran->find($list->id_kriteria)->jenis as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('id_jenis', $list->id_jenis) == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->jenis_pelanggaran }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border py-2 px-4">
                        <button type="button" onclick="removeRow(this)" class="bg-red-500 text-white rounded p-2">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <button type="submit" class="bg-blue-500 text-white rounded p-2 w-fit px-10">Perbarui</button> <!-- Change button label -->
</form>

@endsection

@section('script')

<script>
    var kriteriaPelanggaran = @json($kriteria_pelanggaran);

    var maxRows = kriteriaPelanggaran.length;

    function addRow() {
        var dynamicRows = document.getElementById('dynamicRows');
        var message = document.getElementById('message');

        if (dynamicRows.children.length >= maxRows) {
            alert('Anda tidak dapat menambahkan lebih banyak baris.');
            return;
        }

        if (message) {
            message.style.display = 'none';
        }

        var newRow = document.createElement('tr');

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

        kriteriaPelanggaran.forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option.id;
            opt.innerText = option.kriteria;
            firstSelect.appendChild(opt);
        });

        firstSelectCell.appendChild(firstSelect);
        newRow.appendChild(firstSelectCell);

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

        firstSelect.addEventListener('change', function() {
            updateJenisPelanggaranOptions(firstSelect, secondSelect);
            updateKriteriaOptions();
        });

        var deleteButtonCell = document.createElement('td');
        deleteButtonCell.classList.add('border', 'py-2', 'px-4');
        var deleteButton = document.createElement('button');
        deleteButton.setAttribute('type', 'button');
        deleteButton.setAttribute('onclick', 'removeRow(this)');
        deleteButton.classList.add('bg-red-500', 'text-white', 'rounded', 'p-2');
        deleteButton.innerText = 'Delete';
        deleteButtonCell.appendChild(deleteButton);
        newRow.appendChild(deleteButtonCell);

        dynamicRows.appendChild(newRow);

        updateKriteriaOptions();
    }

    function updateJenisPelanggaranOptions(kriteriaSelect, jenisSelect) {
        if (!kriteriaSelect || !jenisSelect) {
            console.error('Missing select elements');
            return;
        }

        var selectedKriteriaId = kriteriaSelect.value;

        jenisSelect.innerHTML = '';

        var defaultOption = document.createElement('option');
        defaultOption.setAttribute('value', '');
        defaultOption.setAttribute('disabled', 'disabled');
        defaultOption.setAttribute('selected', 'selected');
        defaultOption.innerText = 'Pilih Jenis Pelanggaran';
        jenisSelect.appendChild(defaultOption);

        var selectedKriteria = kriteriaPelanggaran.find(function(kriteria) {
            return kriteria.id == selectedKriteriaId;
        });

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

    function updateKriteriaOptions() {
        var kriteriaSelects = document.querySelectorAll('select[name="id_kriteria[]"]');
        var selectedKriteriaIds = Array.from(kriteriaSelects).map(function(select) {
            return select.value;
        });

        kriteriaSelects.forEach(function(select) {
            var currentSelectedValue = select.value;
            var options = select.querySelectorAll('option');

            options.forEach(function(option) {
                if (option.value === '' || option.value === currentSelectedValue) {
                    option.disabled = false;
                } else if (selectedKriteriaIds.includes(option.value)) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    }

    function removeRow(btn) {
        var row = btn.parentNode.parentNode;
        if (row) {
            row.parentNode.removeChild(row);
        } else {
            console.error('Row not found for the delete button');
        }

        var dynamicRows = document.getElementById('dynamicRows');
        if (dynamicRows.children.length === 0) {
            var message = document.getElementById('message');
            if (message) {
                message.style.display = 'block';
            }
        }

        updateKriteriaOptions();
    }
</script>

@endsection
