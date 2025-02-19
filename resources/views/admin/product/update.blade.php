<x-app-layout>
    <div class="py-12" style="margin-top:60px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-0">Edit Course</h1>
                    <hr />
                    <form action="{{ route('admin/products/update', $products->id) }}" method="POST"
                        enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col mb-3">
                                <lable class="form-lable">Course name</lable>
                                <input type="text" name="Name" class="form-control" placeholder="Name"
                                    value="{{$products->Name}}">
                                @error('Name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <lable class="form-lable">Description</lable>
                                <input type="text" name="Description" class="form-control" placeholder="Description"
                                    value="{{$products->Description}}">
                                    @error('Description')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <lable class="form-lable">Base Mark</lable>
                                <input type="number" name="Base_Mark" class="form-control" placeholder="Base Mark"
                                    value="{{$products->Base_Mark}}" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <lable class="form-lable">Pass Mark</lable>
                                <input type="number" name="Pass_Mark" class="form-control" placeholder="Pass Mark"
                                    value="{{$products->Pass_Mark}}" min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <lable>Uploads Image</lable>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="row">
                            <div class="d-grid">
                                <button class="btn btn-warning">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>