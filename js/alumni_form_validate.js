/**
 * Author: ahmed-dinar
 * Date: 6/2/17
 */


//validate from in front end
$("#alumniForm").validate({
    rules: {
        name: {
            required: true,
            rangelength: [3,100]
        },
        email: {
            required: true,
            email: true,
            remote: {
                url: "validateEmail.php",
                type: "post",
                data: {
                    email: function() {
                        return $( "#inputEmail1" ).val();
                    },
                    csrf: function () {
                        return $( "#csrf_token" ).val();
                    }
                }
            }
        },
        passingYear: {
            required: true,
            number: true,
            rangelength: [4, 4]
        },
        currentOrg: {
            required: false,
            maxlength: 50
        },
        presentAddress: {
            required: false,
            maxlength: 80
        },
        permanentAddress: {
            required: true,
            maxlength: 80
        },
        currentStatus: {
            required: false,
            maxlength: 30
        },
        phone: {
            required: true,
            number: true,
            maxlength: 20
        },
        group: {
            required: true
        },
        // password: {},
        profileImg: {
            required: true,
            accept: "image/jpg,image/jpeg,image/png,image/gif",
            filesize: 1048576
        }
    },
    messages: {
        name:{
            rangelength: "Name must be between 3 and 100 characters long."
        },
        email: {
            required: "Please enter your email address.",
            email: "Please enter a valid email address.",
            remote: jQuery.validator.format("{0} is already taken.")
        },
        profileImg: {
            required: 'Image is required',
            accept: "File must be JPEG or PNG, less than 1MB",
            filesize: "File must be JPEG or PNG, less than 1MB"
        },
        passingYear: {
            number: "Please enter a valid year",
            rangelength: "Please enter a valid year"
        },
        phone: {
            number: "Please enter a valid phone number"
        }
    }
});
