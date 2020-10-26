window.addEventListener('load', function () {
	form_submit();
});

function form_submit() {
	var form = document.getElementsByTagName('form');
	for (let index = 0; index < form.length; index++) {
		form[index].addEventListener('submit', function (el) {

			var loadingBox = document.createElement('div');
			loadingBox.setAttribute('id','loading_box');
			loadingBox.innerHTML = '<img src="https://nycprek.teacherssupportnetwork.com/images/animated_progress.gif">';
			

			var ajax_status = el.target.getAttribute('ajax');

			var response_container = document.getElementById('response_message');
			response_container.innerHTML = '';
			response_container.classList.remove(['success_response','error_response']);

			if (ajax_status) {
				el.preventDefault();
				
				var form = el.target;
				var error = false;

				// Form validation
				for (let index = 0; index < form.length; index++) {
					var id = form[index].getAttribute('id');
					var validate = valid(form[index]);
					var removeEl = document.getElementById(id+'_error');
					if(removeEl){
						removeEl.parentNode.removeChild(removeEl);
					}
					if(validate){
						var error = document.createElement('span');
						error.setAttribute('id',id+'_error');
						error.setAttribute('class','error_class');
						error.innerText = validate;
						form[index].parentNode.appendChild(error);
						error = true;
					}
				}
				
				//Ajax Submittion
				if(!error){
					el.target.appendChild(loadingBox);
					var data = new FormData(el.target);
					var request = new XMLHttpRequest();
					request.onload = function () {
						if (request.readyState == 4 && request.status == 200) {
							var response = JSON.parse(request.responseText);
							if(response.status){
								response_container.innerHTML = response.message;
								response_container.classList.add('error_response');
								el.target.removeChild(loadingBox);
							}else{
								response_container.innerHTML = response.message;
								response_container.classList.add('success_response');
								// Blank The value 
								document.getElementById('user_first_name').value = '';
								document.getElementById('user_last_name').value = '';
								document.getElementById('user_phone').value = '';
								document.getElementById('user_email').value = '';
								document.getElementById('user_comment').value = '';
								el.target.removeChild(loadingBox);
							}
							
						}
					}
					request.open('POST', cf_cms.ajax, true);
					request.send(data);
				}
				
			}
		});
	}
}

function valid(element) {
	var validate = element.getAttribute('valid');
	var type = element.getAttribute('type');
	var value = element.value;
	var emailCheck = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
	var phoneCheck = /^[0-9]{10}$/;
	var response = false;
	if(validate){
		switch (type) {
			case 'email':
				if(value==""){
					response = "Please Enter Valid Email";
				}else if(value!="" && !emailCheck.test(value)){
					response = "Email is wrong. Please Enter Valid Email";
				}
			break;

			case 'phone':
				if(value==""){
					response = "Please Enter Valid Mobile Number";
				}else if(value!="" && !phoneCheck.test(value)){
					response = "Email is wrong. Please Enter Valid Mobile Number";
				}
			break;
		
			default:
				if(value==""){
					response = "Please Enter Valid detail";
				}
			break;
		}
	}
	return response;
}