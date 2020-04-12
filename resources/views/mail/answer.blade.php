<style>
    #message{
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }
    #message-header{
        padding: .75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0,0,0,.03);
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    #message-body{
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
        color: #17a2b8!important;
    }
    #message-title{
        margin-bottom: .75rem;
        font-size: 1.25rem;
    }
    .message-text{
        color: #17a2b8!important;
    }
</style>
<div id="message">
    <div id="message-header">{{__('Ответ от ') . Auth::user()->name . __(' по заявка')}}</div>
    <div id="message-body">
        <h5 id="message-title">{{$complaint->theme}}</h5>
        <p class="message-text">{{$complaint->message}}</p>
        <p>{{__('Ответь:')}}</p>
        <p class="message-text">{{$answer->text}}</p>
    </div>
</div>