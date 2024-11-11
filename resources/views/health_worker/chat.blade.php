@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <!-- Back Button to return to Dashboard -->
    <a href="{{ url('/dashboard') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
    </a>

    <!-- Chat Box -->
    <div class="card">

        <div class="card-header">
            <h5>Chat with 
                @if($feminineUser)
                    {{ $feminineUser->first_name . ' ' . $feminineUser->last_name }}
                @else
                    User not found
                @endif
            </h5>
        </div>

        <div class="card-body" id="chatMessages" style="max-height: 400px; overflow-y: auto;">

            <!-- Message List -->
            <div id="messageContainer">
                @foreach($chatMessages as $message)
                    <div class="d-flex mb-3">
                        @if($message->sender_id == Auth::id())
                            <!-- Health Worker Message (Sender) -->
                            <div class="ml-auto">
                                <div class="bg-primary text-white p-2 rounded">
                                    <p>{{ $message->message }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Feminine User Message (Receiver) -->
                            <div>
                                <div class="bg-light p-2 rounded">
                                    <p>{{ $message->message }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Message Input -->
        <div class="card-footer">
            @if($feminineUser) <!-- Ensure feminineUser is not null before displaying the form -->
            <form id="messageForm" action="{{ route('chat.sendMessage') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $feminineUser->id }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="message" id="messageInput" placeholder="Type a message..." required>
                    <button class="btn btn-primary" type="submit" id="sendMessageButton"><i class="bi bi-send"></i></button>
                </div>
            </form>
            @else
                <p class="text-center">Unable to start chat. User not found.</p>
            @endif
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // Scroll to the latest message
    const messageContainer = document.getElementById('chatMessages');
    if (messageContainer) {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
</script>
@endsection
