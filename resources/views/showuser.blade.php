<x-app-layout>
    <div class="py-12" style="margin-top:90px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    </hr>
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    @if(Session::has('show_table'))
                        <table id="table_user" class='table table-hover'>
                            <thead class="table-primary">
                                <tr>
                                    <th>Course</th>
                                    <th>Mark</th>
                                    <th>Base Mark</th>
                                    <th>Pass Mark</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    @else
                        <h1>you do not have any course</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('posts/getuser', ['email' => Auth::user()->email]) }}',
            columns: [
                { data: 'Course' },
                { data: 'markuser' },
                { data: 'Basemark' },
                { data: 'Passmark' },
                { data: 'Result' }
            ]
        });
        $('#table_user_length select').css({
            'width': '60px'
        });
    });
</script>