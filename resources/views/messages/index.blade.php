@extends('layouts.app')


@section('styles')
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<link rel="stylesheet" href="{{ url('css/chat.css') }}">
@endsection

@section('content')
    @php
        $active_chat = 'active';
        $active_conversation = \App\User::find($active_chat_id);
    @endphp
    <div id="frame">
        <div id="sidepanel">
            <div id="contacts">
                <ul>
                    @foreach($from_users as $index => $row)
                        {{-- Don't show if 'from_user_id' equals 'to_user_id' --}}
                        @if($row->from_user_id != $row->to_user_id)
                            <?php $_show = $row->from_user_id != \Auth::user()->id ? $row->from_user_id : $row->to_user_id;  ?>
                            <li class="contact {{ $active_chat_id == $row->from_user_id ? $active_chat : '' }}" onclick="window.location='{{ route('messages.show', $_show) }}'">
                                <div class="wrap">
                                    <img src="{{ url($row->from_user->avatar) }}" alt="" />
                                    <div class="meta">                                        
                                        <p class="name">{{ ucwords($row->from_user->name) }}</p>
                                        <p class="preview">{!!  $row->last_message !!}</p>
                                    </div>

                                </div>
                                <div class="notification">
                                    @if(\Helper::get_unread_message_count() > 0)
                                    <span class="badge badge-pill badge-warning unread_noti">{{\Helper::get_unread_message_count()}}</span>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="content @isset($no_active_conversation) no-conversation-active @endisset">
            @isset($no_active_conversation)
            <div style="width: 100%;">
                <i class="fa fa-comments" style="font-size: 80px;"></i>
                <h1>No, active conversation.</h1>
            </div>
            @else
            <div class="contact-profile">
                <img src="{{ url($active_conversation->avatar) }}" alt="" />

                <p>{{ ucwords($active_conversation->name) }}</p>
                <div class="social-media">
                    <i class="fa fa-trash delete" onclick="event.preventDefault();if(confirm('Etes vous sure de vouloir supprimer?')) document.delete_chat.submit();" data-id="{{ $active_chat_id }}" aria-hidden="true"></i>
                    <form method="post" name="delete_chat" action="{{ route('messages.destroy', $active_chat_id) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                </div>
            </div>
            <div class="messages">
                <ul>
                    @foreach($messages as $key => $message)    

                        @if($message->from_user_id == \Auth::user()->id)
                            <li class="{{ \App\PostsMessages::REPLY_CLASS }}" data-id="{{ $message->id }}" data-post_id="{{ $message->post_id }}">
                                <img src="{{ url($message->from_user->avatar) }}" alt="" />
                                <p>{{ $message->message }}</p>
                            </li>
                            @else
                            <li class="{{ \App\PostsMessages::SENT_CLASS }}" data-id="{{ $message->id }}" data-post_id="{{ $message->post_id }}">
                                <img src="{{ url($message->from_user->avatar) }}" alt="" />
                                <p>{{ $message->message }}</p>
                            </li>
                        @endif

                    @endforeach
                </ul>
            </div>
            <div class="message-input">
                <div class="wrap">
                <input type="text" class="message_text" placeholder="Write your message..." />
                <button class="sent_message"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
            </div>
            @endisset
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            let _token = $('meta[name="csrf-token"]').attr('content');

            @isset($active_chat_id)

            function scroll_to_last_message()
            {
                $('.messages').animate({
                    scrollTop: $('.messages')[0].scrollHeight
                },
                'slow');
            }

            scroll_to_last_message();

            function append_new_message(id, class_name, post_id, avatar, message)
            {
                $('.messages ul').append('<li class="'+class_name+'" data-id="'+id+'" data-post_id="'+post_id+'"><img src="'+avatar+'" /><p>'+message+'</p></li>');
                scroll_to_last_message();
            }

            function new_messages()
            {
                let last_message_id = $('.messages li:last-child').data('id');
                $.post(
                    '{{ route("messages.new-message", $active_chat_id) }}',
                    {_token: _token, last_message_id: last_message_id},
                    function (data){
                        //console.log(data.length);
                        data.forEach(function(value, index, arr){
                            append_new_message(value.id, value.class, value.post_id, value.avatar, value.message);
                        });

                        setTimeout(function(){
                            new_messages();
                        }, 700);
                    },
                    'json'
                ).fail(function(){
                    new_messages();
                });
            }

$('.message_text').on('click', function(e){

      $.get(
            '{{ route("messages.read-message") }}', 
            function(data){
                
            } 
        );
      $('.unread_noti').hide(); 
}); //End focus event
            $('.sent_message').on('click', function(e){
                e.preventDefault();

                let message = $('.message_text').val();
                let post_id = $('.messages li:last-child').data('post_id');

                $.post(
                    '{{ route("messages.store") }}',
                    {
                        _token: _token, 
                        message: message, 
                        conversation_id: {{ $active_chat_id }},
                        post_id: post_id
                    }, 
                    function(data){
                        $('.message_text').val('');
                        append_new_message(data.id, data.class, post_id, data.avatar, message);
                    },
                    'json'
                ).done(function(){
                    toastr.success('Message sent successfully.');
                }).fail(function(){
                    toastr.error('Something went wrong.');
                });
            });
            
            new_messages();
            @endisset
        });
    </script>
@endsection