@extends('layouts.app')
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            $('.message_text').focus(function () {
                $.get('{{ route("messages.read-message") }}');
            });
            $('.post').click(function (e) {

                var posts = $('.post');
                posts.each(function (index, value) {
                    $(posts[index]).removeClass('activePost');
                });
                setTimeout(function () {
                    hide_messaeg_board()
                }, 1000);

                $(this).addClass('activePost');
            });

            function hide_messaeg_board() {
                var posts = $('.post');
                posts.each(function (index, value) {
                    if (!$(posts[index]).hasClass('activePost')) {
                        $(posts[index]).find('.message_board').hide();
                    }

                });
            }

            $('.post_phone').click(function (e) {
                e.preventDefault();

                $(this).hide();

                $(this).parent().find('.post_phone_sms').show();
            });

            $('.message_btn').click(function () {
                $(this).parents('.post').find('.message_board').toggle();
            });

            $('.send_msg').click(function (e) {
                e.preventDefault();

                var msg = $(this).parent().find('.message_text').val();
                var postId = $(this).attr('data-postid');
                var toUserId = $(this).attr('data-touserid');
                var fromUserId = $(this).attr('data-fromuserid');

                var this_obj = this;

                var msg_wrapper = $(this).parent('.outer_message').find('.messages');
                var msg_text = $(this).parent('.outer_message').find('.message_text')

                $.ajax({
                    type: 'POST',
                    url: "{{ route('news.post.message') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        message: msg,
                        to_user_id: toUserId,
                        from_user_id: fromUserId,
                        post_id: postId
                    },
                    success: function (data) {
                        if (data.success == true) {
                            msg_text.val('');

                            var new_msg = '<div class="msg sender_user" data-msgId="' + data.data.id + '">' + data.data.from_user.name + ': ' + data.data.message + '</div>';

                            msg_wrapper.append(new_msg);

                            $(msg_wrapper).scrollTop(999999);
                        } else {
                            $(this).parent().find('.message_text').empty();
                            alert('Message could not be sent');
                        }
                    }

                });
            });

            setInterval(function () {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('news.post.message') }}",
                    success: function (data) {
                        for (var i = 0; i < data.length; i++) {
                            var val = data[i];
                            var msg_wrap = $('.messages[data-postid="' + val.post_id + '"]');
                            var messages = msg_wrap.find('.msg');

                            var ids = [];
                            messages.each(function (ind, val) {
                                var msg_id = $(val).attr('data-msgid');

                                ids.push(msg_id);
                            });

                            if (ids.indexOf(val.id.toString()) < 0) {
                                var new_msg = '<div class="msg receiver_user" data-msgId="' + val.id + '">' + val.from_user.name + ': ' + val.message + '</div>';
                                msg_wrap.append(new_msg);
                            }
                        }
                    }

                });
            }, 6000)
        });

        function checkbox() {
            var checkboxes = document.querySelectorAll('.form-check-input:checked').length
            if (checkboxes >= 2) {
                document.getElementById("open-button").style.display = "block";
            } else {
                document.getElementById("open-button").style.display = "none";
            }

        }

        function openForm() {
            document.getElementById("myForm").style.display = "block";
            document.getElementById("open-button").style.display = "none";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
            document.getElementById("open-button").style.display = "block";
        }

    </script>
@endsection

@section('styles')
    <style>
        .activePost {
            background: rgba(0, 0, 0, 0.2) !important;
        }

        .post_map {
            display: none;
        }

        .activePost .post_map {
            display: block;
        }

        .post_phone_sms {
            display: none;
        }

        /* The popup chat - hidden by default */
        .chat-popup {
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }

        /* Full-width textarea */
        .form-container textarea {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
            resize: none;
            min-height: 200px;
        }

        /* When the textarea gets focus, do something */
        .form-container textarea:focus {
            background-color: #ddd;
            outline: none;
        }


        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
        }
        .custom-control-input:checked ~ .custom-control-label:before {
            color: #fff;
            border-color: gold;
            background-color: gold;
        }


    </style>
@endsection

@section('content')
    <div class="container">
        <!--SEARCH-->
        <div class="row">
            <div class="col-md-12 row search" style="margin-bottom: 19px;">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Que  recherchez vous" value="">
                </div>
                <div class="col-md-4">
                    <a class="form-control" type="button" data-toggle="collapse" data-target="#collapseSearch"
                       aria-expanded="false" aria-controls="collapseSearch">
                        Filter <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-md-3">
                    <button class="form-control">Rechercher sur la carte</button>
                </div>

            </div>
            <div class="col-md-3 offset-md-5">
            </div>
            <div class="collapse" id="collapseSearch">
                <div class="card card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right"></label>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Titres" value="">
                        </div>

                        <div class="col-md-4">
                            <select name="" class="form-control">
                                <option value="asc">Quantity</option>
                                <?php $i = 1; while($i < 101){?>
                                <option value="desc"><?php echo $i;?></option>
                                <?php $i++; } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Hbeginrdv" class="col-md-2 col-form-label text-md-right">Heure rdv entre</label>
                        <div class="col-md-4">
                            <input id="time_e" type="time" class="form-control " value="" name="time_b" required
                                   autocomplete="Date">
                        </div>
                        <div class="col-md-4">
                            <input id="time_e" type="time" class="form-control" value="" name="time_e" required
                                   autocomplete="Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_b" class="col-md-2 col-form-label text-md-right">Date rdv entre</label>
                        <div class="col-md-4">
                            <input id="date_b" type="date" class="form-control" value="" name="" required
                                   autocomplete="Date">
                        </div>
                        <div class="col-md-4">
                            <input id="date_e" type="date" class="form-control" value="" name="date_e" required
                                   autocomplete="Date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="adresse" class="col-md-2 col-form-label text-md-right">Adresse rdv</label>
                        <div class="col-md-8">
                            <input id="adresse_ajax" type="text" class="form-control" value="" name="adressajax"
                                   required autocomplete="Date" list="adressajaxs" onkeypress="ajaxadress(this)">
                            <datalist id="adressajaxs"></datalist>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End row-->
        <!-- END-->
        <div class="row justify-content-center py-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"
                         style="background-color: rgb(160, 160, 160);;text-align: center;color: white;padding: 50px">
                        <h4>Espace Pub</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="card-body"
                     style="background-color: rgb(160, 160, 160);;text-align: center;color: white;padding: 500px 0">
                    <h4>Espace Pub</h4>
                </div>
            </div>
            <div class="col-md-8">
                @if ($message = Session::get('success'))
                    <div class="alert btn-gold alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form action="{{ route('message.all') }}" method="POST">
                    @csrf
                    <div class="row justify-content-end post">
                        <a class="btn btn-gold open-button message_btn" id="open-button" onclick="openForm()"
                           style="display: none;color: white">Envoyer un
                            message au groupe</a>
                        <div class="chat-popup" id="myForm">
                            <div class="form-container">
                                <button type="button" class="btn btn-sm cancel" onclick="closeForm()"
                                        style="float: right">X
                                </button>
                                <h4>Message au groupe</h4>
                                <textarea placeholder="tapez votre message.." name="msg" required></textarea>

                                <button type="submit" class="btn btn-gold">Envoyer</button>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @foreach($posts as $post)
                            <div class="row col-md-12 post" style="margin: 20px">
                                @if($post->user_id != Auth::id())
                                    <div class="message_board">
                                        <div class="top_banner">
                                            <div class="banner_add">
                                                <button class="min_message btn-danger"><i
                                                        class="fa fa-window-minimize"></i>
                                                </button>
                                                <img style="width: 39px; border-radius: 3px;"
                                                     src="{{ asset($post->user->avatar) }}">
                                                <span><?php echo $post->titre;?></span>
                                            </div>
                                        </div>
                                        <div class="outer_message ">
                                            <div class="messages" data-postid="{{ $post->id }}">
                                                @foreach($post->messages as $message)
                                                    <?php
                                                    $div_class = 'receiver_user';
                                                    if (Auth::id() == $message->from_user_id) {
                                                        $div_class = 'sender_user';
                                                    }
                                                    ?>
                                                    <div class="msg <?php echo $div_class;?>"
                                                         data-msgId="{{ $message->id }}">{{ $message->from_user->name.': '.$message->message }}</div>
                                                @endforeach
                                            </div>
                                            <input class="message_text" type="text">
                                            <button data-postid="{{ $post->id }}" data-touserid="{{ $post->user_id }}"
                                                    data-fromuserid="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                                    class="send_msg btn btn-gold"
                                                    style="width: 30%; float: right;border-radius: unset">Envoyer
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="container" style="padding: unset">
                                    <div class="row">
                                        <div class="col-md-3" style="max-width:unset;padding: unset">
                                            <img width="210px" src="{{ asset($post->user->avatar) }}">
                                        </div>
                                        <div class="col-md-7 ">
                                            <p> Titre: {{ $post->titre }}</p>
                                            <p> Quantité : {{ ( $post->qte )}} entre {{ ( $post->quantite2 )}} </p>
                                            <p>Date du rdv: {{ $post->daterdvbegin . ' à  '. $post->daterdvend }}</p>
                                            <p>Heure du rdv: {{ $post->Hbeginrdv . ' à  '. $post->Hendrdv }}</p>
                                            <p>Adresse: {{ $post->adresse }}</p>
                                        </div>
                                        @if($post->user_id != Auth::id())
                                            <div class="col-md-1 align-self-center">
                                                <div class="custom-control custom-checkbox">
                                                    <input class=" form-check-input custom-control-input" name="ids[]"
                                                           value="{{ $post->id }},{{ $post->user->id }}" type="checkbox"
                                                           onchange="checkbox()" id="customControlAutosizing{{ $post->id }}">
                                                    <label class="custom-control-label" for="customControlAutosizing{{ $post->id }}"></label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12 post_map" style="padding: 0px;">
                                    <div style="width: 100%">
                                        <iframe width="100%" height="180" frameborder="0" scrolling="no"
                                                marginheight="0"
                                                marginwidth="0"
                                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                                    </div>

                                    <div class="text-center">
                                        <div>
                                            <button class="btn btn-info post_phone" style="width: 180px;">Appeler ou SMS
                                            </button>
                                            <button class="btn btn-primary post_phone_sms" disabled
                                                    style="width: 180px;">{{ $post->user->phone }}</button>
                                        </div>
                                    </div>

                                    @if($post->user_id != Auth::id())
                                        <div class="text-center">
                                            <button class="btn btn-gold message_btn"
                                                    style="width: 180px; margin-top: 10px; margin-bottom: 10px;">Envoyer
                                                un
                                                message
                                            </button>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <a href="javascript:void(0)" data-href="{{url('messages')}}"
                                               class="btn btn-gold chat_window"
                                               style="width: 180px; margin-top: 10px; margin-bottom: 10px;">Envoyer un
                                                message</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        {{ $posts->links() }}
                    </div>
                </form>
            </div>

            <div class="col-md-2">
                <div class="card-body"
                     style="background-color: rgb(160, 160, 160);;text-align: center;color: white;padding: 500px 0">
                    <h4>Espace Pub</h4>
                </div>
            </div>

        </div>
    </div>
    <script>

        $(document).on('click', '.chat_window', function () {
            var href = $(this).attr('data-href');
            window.location.href = href;
        });
        $(document).on('click', '.min_message', function () {
            $(this).parents('.message_board').hide();
        });
        $('#select_filter').change(function () {
            var val = $(this).val();
            if (val == 'filter') {
                $('#collapseSearch').toggle('open');
            } else {
                $('#collapseSearch').toggle('close');
            }
        });

    </script>
@endsection
