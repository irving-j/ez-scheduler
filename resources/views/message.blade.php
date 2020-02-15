<div class="content" id="messages">
	<fieldset>
		<input type="text" id="new-msg-id" />
		<label >To:</label>
		<select class="recipientsselector" id="slctrecipients">
		</select><br>
		<div id="msg-recipients"></div>
		<label>Subject:</label>
		<input type="text" id="new-msg-subject"/><br>
		<textarea id="new-msg-body"></textarea><br>
		<button id="send-message" onclick="sendMessage()">Send</button><br>
	</fieldset>
</div>
<div class="content" id="message-viewer">
	<fieldset>
		<input type="text" id="msg-id" />
		<button id="reply" onclick="replyMessage()">Reply</button><button id="forward" onclick="forwardMessage()">Forward</button><button id="delete-open" >Delete</button><br>
		<label >From:</label>
		<input type="text" id="from"/><input type="text" id="from-id" hidden/><br>
		<label>Subject:</label>
		<input type="text" id="msg-subject"/><br>
		<textarea id="msg-body"></textarea><br>
	</fieldset>
</div>
