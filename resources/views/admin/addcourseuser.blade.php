<x-app-layout>
    <div class="py-12" style="margin-top:60px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-0">Add Course for student</h1>
                    <hr />
                    <form action="{{ route('admin/assign') }}" enctype='multipart/form-data' id="AddCourseForm">
                        @csrf
                        <label for="country">Courses :</label>
                        @if (Session()->has('error'))
                            <div>
                                {{Session('error')}}
                            </div>
                        @endif
                        <select name="Course" style="margin-left:10px">
                            @forelse ($course as $courses)
                                <option class="btn" vlaue="$courses->Name">{{ $courses->Name}}</option>
                            @empty
                                <p class="text-center" colspan="5">Cousrse empty</p>
                            @endforelse
                        </select>
                        <br>
                        <br>
                        <span class="text-danger" id="error"></span>
                        <input type="text" name="Email" class="from-control" placeholder="Base Mark"
                            value="{{$emailluser}}" hidden>
                            <input type="text" name="teacher_id" class="from-control" placeholder="teacher_id"
                            value="{{ Auth::user()->id }}" hidden>
                        <div class="row">
                            <div class="d-grid">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        $('#AddCourseForm').on('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $('#AddCourseForm').attr('action'),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#error').html('<p style="color: green;">' + response.success + '</p>');
                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    $('#error').html('<p style="color: red;">' + errors.name[0] + '</p>');
                }
            });
        });
    });
</script>