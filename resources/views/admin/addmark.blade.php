<x-app-layout>
    <div class="py-12" style="margin-top:60px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-0">Add Mark for student</h1>
                    <hr />
                    <form action="{{ route('admin/addnmark') }}" method="POST" enctype='multipart/form-data' id="FormAddMark">
                        @csrf
                        @if (Session()->has('error'))
                        <div>
                            {{Session('error')}}
                        </div>
                    @endif
                        <lable>Add Mark : </lable>
                        <input type="number" name="Base_Mark" class="from-control" placeholder="Base Mark" min="0"
                            required>
                        <input type="text" name="Email" class="from-control" value="{{$emailluser}}" hidden>
                        <input type="text" name="Course" class="from-control" value="{{$corse}}" hidden>
                        <br><div id="message" style="color:red"></div><br>
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
        $('#FormAddMark').on('submit', function (event) {
            event.preventDefault(); 
            var formData = new FormData(this); 
            $.ajax({
                url: $('#FormAddMark').attr('action'),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    }
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                        $('#message').text(errors);
                }
            });
        });
    });
</script>