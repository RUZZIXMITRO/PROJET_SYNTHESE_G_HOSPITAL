document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('message-input');
    const chatMessages = document.getElementById('chat-messages');
    const userNameElement = document.getElementById('userName');
    
    
    
    var userName ='';
    userNameElement.textContent = userName;
    
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    function sendMessage() {
        const messageText = messageInput.value.trim();
        
        if (messageText) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex items-end justify-end space-x-2';
            
            messageDiv.innerHTML = `
                <div class="max-w-md">
                    <div class="bg-blue-500 text-white rounded-lg p-4 shadow-sm">
                        <div class="font-bold mb-1">${userName}</div>
                        ${messageText}
                    </div>
                    <div class="text-right mt-1">
                        <span class="text-xs text-gray-500">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            messageInput.value = '';
        }
    }
    
    document.querySelector('button').addEventListener('click', sendMessage);
});