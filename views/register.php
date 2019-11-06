<iframe width="100%" height="450" src="https://maps.google.com/maps?q=7060%20Hollywood%20Blvd%2C%20Los%20Angeles%2C%20CA&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h4 id="form_header" class="mt-3 text-center">To participate in the conference, please fill out the form</h4>

            <section id="errors" class="errors text-center border hidden"></section>

            <form id="register_form">

                <div class="form-group">
                    <label for="first_name">First name (*): </label>
                    <input type="text" maxlength="45" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="Enter first name" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last name (*): </label>
                    <input type="text" maxlength="45" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Enter last name" required>
                </div>

                <div class="form-group">
                    <label for="birth_date">Birth date (*): </label>
                    <input type="text" class="form-control form-control-lg" id="birth_date" name="birth_date" placeholder="Enter date of birth" required readonly>
                </div>

                <div class="form-group">
                    <label for="report_subject">Report subject (*): </label>
                    <input type="text" maxlength="200" class="form-control form-control-lg" id="report_subject" name="report_subject" placeholder="Enter report subject" required>
                </div>

                <div class="form-group">
                    <label for="country">Country (*): </label>
                    <select class="custom-select form-control form-control-lg" name="country" id="country" required>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?= $country ?>"> <?= $country ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone">Phone number (*): </label><br>
                    <label><b>Tip</b>: phone must contain 11 digits</label>
                    <input type="text"
                           maxlength="18"
                           class="form-control form-control-lg"
                           id="phone_number"
                           name="phone_number"
                           placeholder="+X (XXX) XXX XXXX"
                           required>
                </div>

                <div class="form-group">
                    <label for="email">Email (*): </label>
                    <input type="email" maxlength="45" class="form-control form-control-lg" id="email" name="email" placeholder="Enter email" required>
                </div>
                <button type="button" id="to_more_info_form" class="btn btn-primary float-right mt-2 mb-2">Next</button>
            </form>

            <form id="more_info_form" method="POST" class="hidden" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="company">Company: </label>
                    <input type="text" maxlength="45" class="form-control form-control-lg" id="company" name="company" placeholder="Enter company title">
                </div>

                <div class="form-group">
                    <label for="position">Position: </label>
                    <input type="text" maxlength="45" class="form-control form-control-lg" id="position" name="position" placeholder="Enter position">
                </div>

                <div class="form-group">
                    <label for="about">About me: </label>
                    <textarea maxlength="300" class="form-control form-control-lg" id="about" name="about_me" placeholder="Enter some details"></textarea>
                </div>

                <div class="form-group">
                    <label for="photo">Upload avatar: </label>
                    <input type="file" accept="image/*" class="form-control-file" name="photo" id="photo">
                </div>
                <button type="button" id="back-to-register-form" class="btn btn-primary float-left mb-2">Back</button>
                <button type="submit" id="add-info" class="btn btn-primary float-right mb-2">Next</button>
            </form>

            <section id="social" class="hidden text-center mt-3">
                <h4 class="mt-2 mb-2">Registration succeed!</h4>
                <a href="https://www.facebook.com/sharer.php?u=https://www.wikipedia.org/" class="fa fa-facebook"></a>
                <a href="https://twitter.com/intent/tweet?url=<?= $twitterUrl ?>/&text=<?= $twitterText ?>" class="fa fa-twitter"></a>
                <p class="mt-2"><a href="/members" class="text-success h3">All members list (<?= $membersCount + 1 ?>)</a></p>
            </section>

        </div>
    </div>
</div>
