<?php
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
     	
   <!-- All Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Page Title Here -->
	<title><?= $companyName ?> || Sign Up</title>

    <!-- FAVICONS ICON -->
	<link rel="icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">

    <link href="<?= ROOT_URL ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link href="<?= ROOT_URL ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/custom.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dashboard/assets/css/iziToast.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>account/account.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <style>
        html, body{
            /* height: 100%; */
            width: 100%;
        }
        .account-login .login-form {
            padding: 30px;
        }
    </style>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <?php //include_once WEB_ROOT."_includes/preloader.inc.php" ?>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div class="account-login nope">
        <div class="container">
            <!-- <div class="row justify-content-center">
                <div class="col-lg-2">
                    <div class="logo w-100 h-100">
                        <img src="<?= ROOT_URL ?>assets/images/logo/logo.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form inner-content" id="addUser" method="post">
                        <div class="card-body">
                            <div class="title">
                                <h3>Sign Up Now</h3>
                            </div>
                            <div class="input-head">
                                <div class="row">
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="firstname" class="required">First Name</label>
                                            <input class="form-control" type="text" name="firstname" required="" id="firstname">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group">
                                            <label class="form-control-label required" for="lastname">Last Name</label>
                                            <input class="form-control" type="text" name="lastname" required="" id="lastname">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input class="form-control" type="text" name="username" id="username">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group">
                                            <label for="email" class="required">Email </label>
                                            <input class="form-control" type="email" name="email" required="" id="email">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group">
                                            <label class="required">Mobile Number </label>
                                            <div class="input-group ">
                                                <!--<span class="input-group-text mobile-code"><i class="fa-solid fa-phone"></i></span>-->
                                                <input type="number" name="phone" value="" id="mobile" class="form-control checkUser" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="dob">Date of Birth</label>
                                            <input class="form-control" type="date" name="dob" id="dob">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="country">Country</label>
                                            <select name="country" id="country" class="form-control">
                                                <option value="nga">Nigeria</option>
                                            <option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">AndorrA</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo, The Democratic Republic of the</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Cote D'Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and Mcdonald Islands</option><option value="VA">Holy See (Vatican City State)</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran, Islamic Republic Of</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea, Democratic People'S Republic of</option><option value="KR">Korea, Republic of</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Lao People'S Democratic Republic</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libyan Arab Jamahiriya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia, The Former Yugoslav Republic of</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia, Federated States of</option><option value="MD">Moldova, Republic of</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory, Occupied</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">RWANDA</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="CS">Serbia and Montenegro</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suri"name"</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan, Province of China</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania, United Republic of</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands, British</option><option value="VI">Virgin Islands, U.S.</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="occupation">Occupation</label>
                                            <input class="form-control" type="text" name="occupation" id="occupation">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group flex-column">
                                            <label for="gender" class="d-block">Gender</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" checked type="radio" name="gender" id="male" value="male">
                                                <label class="form-check-label" for="male">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                <label class="form-check-label" for="female">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                                                <label class="form-check-label" for="other">Other</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="marital_status">Marital Status</label>
                                            <input class="form-control" type="text" name="marital_status" id="marital_status">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="account_type">Account Type</label>
                                            <input class="form-control" type="text" name="account_type" id="account_type">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="password">Password</label>
                                            <input class="form-control" type="password" name="password" id="password">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="currency">Currency</label>
                                            <select name="currency" class="form-control" id="currency">
                                                <option value="$">Dollar</option>
                                                <option value="€">Euro</option>
                                                <option value="£">Pound</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-group ">
                                            <label for="upload_pic">Upload Picture</label>
                                            <input class="form-control" type="file" name="upload_pic" id="upload_pic">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input class="form-control" type="text" name="address" id="address">
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                            <div class="button flex-column gap-2">
                                <button class="btn w-100" id="addbtn" type="submit">Register</button>
                                <!-- <a class="btn alt" href="<?= ROOT_URL ?>account/signin.php">Sign In Now</a> -->
                                <p>Have an account <a href="<?= ROOT_URL ?>account">Sign in</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= ROOT_URL ?>assets/js/pass-show-hide.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/iziToast.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>
    <script>
        const form = document.querySelector("#addUser"),
        addbtn = form.querySelector("#addbtn"),
        errortext = form.querySelector("#error-txt");

        form.onsubmit = (e) =>{
            e.preventDefault(); // preventing form from submitting
        }

        addbtn.onclick = ()=>{
            let originalText = addbtn.innerText;
            addbtn.disabled = true;
            addbtn.innerText = 'Processing... Please wait';

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT_URL ?>backend/account/register.php", true);
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response ? xhr.response.trim() : '';
                        console.log(data);
                        if(data == 'otp_sent'){
                            iziToast.show({
                                title: 'Success',
                                message: 'Registration successful! An activation OTP has been sent to your email.',
                                position: "topRight",
                                backgroundColor: '#198754',
                                messageColor: '#ffffff',
                                titleColor: '#ffffff'
                            });
                            addbtn.innerText = 'Redirecting to verification...';
                            setTimeout(() => {
                                location.href = '<?= ROOT_URL ?>account/verify_otp.php';
                            }, 1500);
                        } else if(data == 'success'){
                            iziToast.show({
                                title: 'Hey',
                                message: `Registration successful`,
                                position: "topRight",
                                backgroundColor: '#90EE90'
                            });
                            setTimeout(() => {
                                location.href = '<?= ROOT_URL ?>dashboard/user';
                            }, 2000);
                        } else {
                            addbtn.disabled = false;
                            addbtn.innerText = originalText;
                            iziToast.show({
                                title: 'Error',
                                message: data,
                                position: "topRight",
                                backgroundColor: '#FF474C'
                            });
                        }
                    } else {
                        addbtn.disabled = false;
                        addbtn.innerText = originalText;
                    }
                }
            }
            xhr.onerror = () => {
                addbtn.disabled = false;
                addbtn.innerText = originalText;
                iziToast.show({
                    title: 'Error',
                    message: 'Network error. Please try again.',
                    position: "topRight",
                    backgroundColor: '#FF474C'
                });
            };
            //we have to send the form data through ajax to php
            let formData = new FormData(form); //creating new formdata object
            xhr.send(formData); //sending the form data to php
        }
    </script>
</body>
</html>