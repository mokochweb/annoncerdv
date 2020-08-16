@extends('layouts.app') 
@section('scripts')
    
@endsection

@section('styles')
    
@endsection

@section('content')

    <div class="container">
    <!--Section: Contact v.2-->
<section class="mb-4">

    <!--Section heading-->
    <h2 class="h1-responsive font-weight-bold text-center my-4">Contact us</h2>
    <!--Section description-->
    <p class="text-center w-responsive mx-auto mb-5">Avez-vous des questions? N'hésitez pas à nous contacter directement. Notre équipe reviendra vers vous en quelques heures pour vous aider.</p>

    <div class="row">

        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5 offset-md-1">
            @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
            <form id="contact-form" name="contact-form" action="{{url('contact_us')}}" method="POST">
                <?php echo csrf_field();?>
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-md-12">
                        <div class="md-form mb-0"> 
                            <label for="name">Nom</label>
                            <input type="text" id="name" name="name" placeholder="Nom" class="form-control" required>
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-12">
                        <div class="md-form mb-0"> 
                             <label for="email">Email</label>
                            <input type="text" id="email" name="email" placeholder="Email" class="form-control" required>
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0"> 
                            <label for="address">Adresse</label>
                            <input type="text" id="address" name="address" placeholder="Adresse" class="form-control" required>
                        </div>
                    </div>
                </div>
                <!--Grid row-->
                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0"> 
                            <label for="subject">Matière</label>
                            <input type="text" id="subject" name="subject" placeholder="Matière" class="form-control" required>
                        </div>
                    </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12">

                        <div class="md-form">
                            <label for="message">Votre message</label>
                            <textarea type="text" id="message" placeholder="Votre message" name="message" rows="2" class="form-control md-textarea" required></textarea>
                        </div>

                    </div>
                </div>
                <!--Grid row-->
<div class="clearfix"></div>
            <div class="text-center text-md-left" style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
            </form> 
            <div class="status"></div>
        </div>
        <!--Grid column-->
 

    </div>
<script>
//$(function() { 
//  $("#contact-form").validate({
//    rules: { 
//      name: "required",
//      
//      email: {
//        required: true,
//        // Specify that email should be validated
//        // by the built-in "email" rule
//        email: true
//      },
//      address: "required",
//      subject: "required",
//      message: "required" 
//    },
//    // Specify validation error messages
//    messages: {
//      name: "Please enter your name",
//      email: "Please enter a valid email address",
//      address: "Please enter your address",
//      subject: "Please enter your subject",
//      message: "Please enter your message"
//    }, 
//    submitHandler: function(form) {
//      form.submit();
//    }
//  });
//});
</script>
</section>
<!--Section: Contact v.2-->
    </div>
   
@endsection