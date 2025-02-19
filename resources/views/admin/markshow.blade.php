<x-app-layout>
    <div class="py-12" style="margin-top:60px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class='d-flex align-iteam-center justify-content-between'>
                        <h2 class="mb-0">list Course</h2>
                    </div>
                    </hr>
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    <table class='table table-hover'>
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Name Course</th>
                                <th>Add Mark</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration}}</td>
                                    <td class="align-middle">{{ $user->Course}}</td>
                                    <td> <a href="{{ route('admin/assignmark', [$user->Email, $user->Course])}}"
                                            class="btn btn-primary" style='margin-top:10px'>Add Mark</a> </dt>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5">Product not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>