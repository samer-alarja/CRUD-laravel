<x-app-layout>
    <div class="py-12" style="margin-top:60px">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-0">Add Course</h1>
                    <hr />
                    @if (Session()->has('error'))
                        <div>
                            {{Session('error')}}
                        </div>
                    @endif
                    <p><a href="{{ route('admin/products') }}" class="btn btn-primary">go Back</a></p>
                    <form id="ajax-form" action='{{ route("admin/products/save") }}' enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label>Name : </label>
                                <input type="text" name="name" id="name" class="from-control" placeholder="Name">
                                <span class="text-danger" id="name-error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label>Description : </label>
                                <input type="text" name="description" id="description" class="from-control" placeholder="Description">
                                <span class="text-danger" id="description-error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label>Base Mark : </label>
                                <input type="number" id="Base_Mark" name="Base_Mark" class="from-control Base_Mark"
                                    placeholder="Base Mark" min='0' step="any">
                                    <span class="text-danger" id="Base_Mark-error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label>Pass Mark : </label>
                                <input type="number" id="Pass_Mark" name="Pass_Mark" class="from-control Pass_Mark"
                                    placeholder="Pass Mark" min='0' step="any">
                                    <span class="text-danger" id="Pass_Mark-error"></span>
                            </div>
                        </div>
                        <div class="image">
                            <label>
                                <h4>Add image</h4>
                            </label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <span class="text-danger" id="image-error"></span>
                        </div>
                        <br>
                        <div class="row">
                            <div class="d-grid">
                            </div>
                            <button class="btn btn-primary" type="submit" id="submit-btn">Submit</button>
                    </form>
                    <div id="messagesuccess"></div>
                </div>
            </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $('.Base_Mark').on('keyup', function () {
        var baseMark = parseFloat($(this).val());
        if (!isNaN(baseMark)) {
            var halfMark = baseMark / 2;
            $('.Pass_Mark').val(halfMark);
        }
    });

    $(document).ready(function () {
        $('#ajax-form').on('submit', function (event) {
            event.preventDefault(); 
            $('#name-error').text('');
            $('#description-error').text('');
            $('#Base_Mark-error').text('');
            $('#Pass_Mark-error').text('');
            $('#image-error').text('');

            var formData = new FormData(this); 
            $.ajax({
                url: $('#ajax-form').attr('action'),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success){
                        $('#messagesuccess').html('<p style="color: green;">Course Added Successful</p>');
                    }
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.name) {
                    $('#message').html('<p style="color: red;">' + errors.name[0] + '</p>');
                }
                    if(errors.name) {
                        $('#name-error').text(errors.name[0]);
                    }
                    if(errors.description) {
                        $('#description-error').text(errors.description[0]);
                    }
                    if(errors.Base_Mark) {
                        $('#Base_Mark-error').text(errors.Base_Mark[0]);
                    }
                    if(errors.Pass_Mark) {
                        $('#Pass_Mark-error').text(errors.Pass_Mark[0]);
                    }
                    if(errors.image) {
                        $('#image-error').text(errors.image[0]);
                    }
                }
            });
        });
    });
</script>