@extends('layouts.app')
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            $('.post').click(function (e) {
                e.preventDefault();

                var posts = $('.post');
                posts.each(function (index, value) {
                    $(posts[index]).removeClass('activePost');
                });

                $(this).addClass('activePost');
            })

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

                var msg_wrapper = $(this).parent().find('.messages');
                var msg_text = $(this).parent().find('.message_text')

                $.ajax({
                    type: 'POST',
                    url: "{{ route('news.post.message') }}",
                    data: {
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
                        console.log(data);
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
            }, 5000)
        });
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

        .custom_btn {
            background-color: gold;
            padding: 3px 12px;
            border-radius: 16px;
            border: 1px solid gold;
            color: #ffffff !important;
        }


    </style>
@endsection

@section('content')
    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="row">
            @if(isset($posts) && count($posts) > 0)
                @foreach($posts as $post)
                    <div class="row col-md-12 post">
                        <div class="message_board">
                            <div class="top_banner">
                                <button class="min_message"><i class="fa fa-window-minimize"></i>
                                </button>
                                <div class="banner_add">
                                    <img style="width: 39px; border-radius: 3px;"
                                         src="{{ asset($post->user->avatar) }}">
                                    <span><?php echo $post->titre;?></span>
                                </div>
                            </div>
                            <div class="outer_message">
                                <div class="messages" data-postid="{{ $post->id }}"><br>
                                    @foreach($post->messages as $message)
                                        <?php
                                        $div_class = '';
                                        if (Auth::id() == $message->from_user_id) {
                                            $div_class = 'sender_user';
                                        } else if (Auth::id() == $message->to_user_id) {
                                            $div_class = 'receiver_user';
                                        }
                                        ?>
                                        <div class="msg <?php echo $div_class;?>"
                                             data-msgId="{{ $message->id }}">{{   $message->from_user->name.': '.$message->message }}
                                        </div>
                                    @endforeach
                                </div>
                                <input class="message_text" type="text" style="width: 80%; float: left; height: 37px;">
                                <button data-postid="{{ $post->id }}" data-touserid="{{ $post->user_id }}"
                                        data-fromuserid="{{ \Illuminate\Support\Facades\Auth::user()->id }}"
                                        class="send_msg btn btn-primary" style="width: 20%; float: right;">Send
                                </button>
                            </div>
                        </div>

                        <div class="row" style="padding: 0px">
                            <div class="col-md-3">
                                <div>
                                    <img style="width: 100%;" src="{{ asset($post->user->avatar) }}">
                                </div>
                                <div></div>
                            </div>
                            <div class="col-md-9">
                                <p> Titre: {{ $post->titre }}</p>
                                <p> Quantités : {{ ( $post->qte )}} entre {{ ( $post->quantite2 )}} </p>
                                <p>Date du rdv: {{ $post->daterdvbegin . ' à  '. $post->daterdvend }}</p>
                                <p>Heure du rdv: {{ $post->Hbeginrdv . ' à  '. $post->Hendrdv }}</p>
                                <p>Adresse: {{ $post->adresse }}</p>
                            </div>

                        </div>

                        <div class="col-md-12 post_map" style="padding: 0px;">
                            <div style="width: 100%">
                                <iframe width="100%" height="180" frameborder="0" scrolling="no" marginheight="0"
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

                            <div class="text-center">
                                <button class="btn btn-warning message_btn"
                                        style="width: 180px; margin-top: 10px; margin-bottom: 10px;">Envoyer un message
                                </button>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div style="float: right;">
                                <a href="javascript:void(0)" class="custom_btn">REPUBLIER</a>
                                <a href="javascript:void(0)" data-href="{{ route('posts.delete', $post->id) }}"
                                   class="custom_btn btn_del">SUPPRMER</a>
                                <a class="custom_btn btn_edit" href="javascript:void(0)"
                                   data-href="{{ route('posts.edit', $post->id) }}">MODIFIER</a></div>

                        </div>
                        <br>
                        <br>
                        <div class="clearfix"></div>


                    </div>
                @endforeach
                {{ $posts->links() }}
            @else
                <div class="alert alert-warning col-md-12">Aucun résultat trouvé</div>
            @endif

        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', '.btn_del', function (e) {
            e.preventDefault();
            var hrf = $(this).attr('data-href')
            if (confirm('Are you sure to delete this record?')) {
                window.location.href = hrf;
            }

        });
        $(document).on('click', '.post', function () {
            //$('.message_board').hide();
        });
        $(document).on('click', '.btn_edit', function (e) {
            e.preventDefault();
            var hrf = $(this).attr('data-href')
            window.location.href = hrf;

        });

        $(document).on('click', '.min_message', function () {

            $(this).parents('.message_board').hide();
        });
    </script>
@endsection
