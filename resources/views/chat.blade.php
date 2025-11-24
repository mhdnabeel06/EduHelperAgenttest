<!doctype html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <title>EduHelperAgent </title>
  <style>
    body{font-family:Arial, Helvetica, sans-serif; max-width:800px;margin:30px auto;}
    .chat{border:1px solid #ddd;padding:12px;border-radius:6px; min-height:220px; overflow:auto;}
    .msg.user{color:#0b4bd4;margin:8px 0;}
    .msg.agent{color:#2a7a2a;margin:8px 0;}
    .controls{margin-top:12px;}
    input[type="text"]{width:70%;padding:8px;}
    button{padding:8px 12px;}
  </style>
</head>
<body>
  <h2>EduHelperAgent </h2>

  <div class="chat" id="chat">
    @if(session('edu_history'))
      @foreach(session('edu_history') as $item)
        <div class="msg {{ $item['sender'] == 'user' ? 'user' : 'agent' }}">
          <strong>{{ $item['sender'] == 'user' ? 'You:' : 'EduHelperAgent:' }}</strong>
          {{ $item['message'] }}
        </div>
      @endforeach
    @else
      <em>No conversation yet. Ask about Solar System, Fractions, or Water Cycle.</em>
    @endif
  </div>

  <div class="controls">
    <input type="text" id="message" placeholder="Ask about Solar System, Fractions, or Water Cycle">
    <button id="askBtn">Ask</button>
    <button id="clearBtn">Clear</button>
  </div>

<script>
  const token = document.querySelector('meta[name="csrf-token"]').content;

  async function postMessage(msg) {
    const res = await fetch('/chat', {
      method: 'POST',
      headers: {
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ message: msg })
    });
    return res.json();
  }

  document.getElementById('askBtn').addEventListener('click', async () => {
    const input = document.getElementById('message');
    const q = input.value.trim();
    if (!q) return alert('Type a question');

    // optimistic UI
    const chat = document.getElementById('chat');
    chat.innerHTML += `<div class="msg user"><strong>You:</strong> ${q}</div>`;

    const data = await postMessage(q);

    chat.innerHTML += `<div class="msg agent"><strong>EduHelperAgent:</strong> ${data.reply}</div>`;
    chat.scrollTop = chat.scrollHeight;

    input.value = '';
  });

  document.getElementById('clearBtn').addEventListener('click', async () => {
    await fetch('/chat-clear', {
      method:'POST',
      headers: { 'X-CSRF-TOKEN': token }
    });
    document.getElementById('chat').innerHTML = '<em>No conversation yet. Ask about Solar System, Fractions, or Water Cycle.</em>';
  });
</script>
</body>
</html>
