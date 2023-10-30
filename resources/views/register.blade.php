

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<h2>Registration Form</h2>
<form id="registrationForm" enctype="multipart/form-data" class="needs-validation">
    @csrf

    <!-- Step 1: Personal Information -->
    <div id="step1">
        <div class="mb-3">
            <label for="first_name" class="form-label">first_name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">last_name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Password confirmation">
		</div>  
        <div>
            <button id="nextStep1" class="btn btn-primary">Next</button>
        </div>
    </div>

    <!-- Step 2: Additional Information -->
    <div id="step2" style="display: none;">
        <div class="mb-3">
            <label class="form-label">Gender:</label>
            <div class="form-check">
                <input type="radio" name="gender" value="male" class="form-check-input">
                <label class="form-check-label">Male</label>
            </div>
            <div class="form-check">
                <input type="radio" name="gender" value="female" class="form-check-input">
                <label class="form-check-label">Female</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Language:</label>
            <div class="form-check">
                <input type="checkbox" name="francais" value="francais" class="form-check-input">
                <label class="form-check-label">français</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="anglais" value="anglais" class="form-check-input">
                <label class="form-check-label">anglais</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Do you have a passport?</label>
            <div class="form-check">
                <input type="radio" name="checkpasseport" value="non" onchange="togglePassportField(false)" class="form-check-input">
                <label class="form-check-label">No</label>
            </div>
            <div class="form-check">
                <input type="radio" name="checkpasseport" value="oui" onchange="togglePassportField(true)" class="form-check-input">
                <label class="form-check-label">Yes</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="passport" class="form-label">If yes, passport number:</label>
            <input type="text" name="passport" id="passport" class="form-control" disabled>
        </div>
        <div>
            <button id="prevStep2" class="btn btn-secondary">Previous</button>
            <button id="nextStep2" class="btn btn-primary">Next</button>
        </div>
    </div>

    <!-- Step 3: Additional Information -->
    <div id="step3" style="display: none;">
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth:</label>
            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" required>
        </div>
        <div class="mb-3">
            <labelfor="marital_status" class="form-label">Marital Status:</label>
            <div class="form-check">
                <input type="radio" name="marital_status" value="single" class="form-check-input">
                <label class="form-check-label">Single</label>
            </div>
            <div class="form-check">
                <input type="radio" name="marital_status" value="married" class="form-check-input">
                <label class="form-check-label">Married</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image:</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control" required>
        </div>
        <div>
            <button id="prevStep3" class="btn btn-secondary">Previous</button>
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </div>
</form>
<div class="text-center">Already have an account? <a href="{{ route('login/view/new') }}">Sign in</a></div>
<style>
    /* Form styles */
    #registrationForm {
        background-color: #f2f2f2;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-width: 500px;
        margin: 0 auto;
    }

    /* Step styles */
    #step2,
    #step3 {
        display: none;
    }

    /* Button styles */
    .btn {
        margin-top: 10px;
    }
</style>



<!-- Add Bootstrap JS at the end of the body -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    function togglePassportField(enabled) {
        var passportField = document.getElementById("passport");
        passportField.disabled = !enabled;
    }

    $(document).ready(function () {
        $('#date_of_birth').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });

        var currentStep = 1;


        function validateStep1() {
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();
    var password = $('#password').val();

    if (name === '' || email === '' || password === '') {
        alert('Please fill in all fields.');
        return false;
    }

    return true;
}

        // Navigate to the next step
        function nextStep() {
            $('#step' + currentStep).hide();
            currentStep++;
            $('#step' + currentStep).show();
        }

        // Navigate to the previous step
        function prevStep() {
            $('#step' + currentStep).hide();
            currentStep--;
            $('#step' + currentStep).show();
        }

        // Handle "Next" button clicks
        $('#nextStep1').click(function (e) {


            e.preventDefault();
            nextStep();
        });

        $('#nextStep2').click(function (e) {
            e.preventDefault();
            nextStep();
        });


        // Handle "Previous" button clicks
        $('#prevStep2').click(function (e) {
            e.preventDefault();
            prevStep();
        });

        $('#prevStep3').click(function (e) {
            e.preventDefault();
            prevStep();
        });

        // Reset the form and go back to the first step
        function resetForm() {
            $('#registrationForm')[0].reset();
            currentStep = 1;
            $('#step2, #step3').hide();
            $('#step1').show();
        }

        // Handle form submission
        $('#registrationForm').submit(function (e) {
            e.preventDefault();

            // Perform form validation before submitting the final step

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "{{ route('form/request/save') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Registration successful!');
                    resetForm(); // Reset the form after successful registration
                    // Redirect or perform any other action after successful registration
                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    console.log(errors);
                    // Handle validation errors and display them to the user
                }
            });
        });
    });
</script>
</body>
</html>