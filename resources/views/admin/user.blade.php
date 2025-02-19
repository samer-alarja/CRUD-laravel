<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class='d-flex align-iteam-center justify-content-between'>
                        <h2 class="mb-0">list Student</h2>
                    </div>
                    </hr>
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    <table id="posts-table" class='table table-hover'>
                        <thead class="table-primary">
                            <tr>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Add Course</th>
                                <th>Add Mark</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        $('#posts-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('posts.getData') }}',
            columns: [
                { data: 'name' },
                { data: 'last_name' },
                { data: 'addcourse', orderable: false, searchable: false },
                { data: 'addmark', orderable: false, searchable: false }
            ]
        });
        $('#posts-table_length select').css({

            'width': '60px'
        });
    });

</script>