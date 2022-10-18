
function Ajax(){
	
	this.url = ""
	this.method = ""
	this.post = function(url){
		this.url = url
		this.method = "POST"
		return this
	}

	this.get = function(url){
		this.url = url
		this.method = "GET"
		return this
	}

	this.execute = function(data, result){
		$.ajax({
            url: this.url,
            method: this.method,
            data: data,
            success: function(res){
            	result(res)
            }
        })
	}

	this.execute_form = function(data, result){
		$.ajax({
            url: this.url,
            method: this.method,
            processData: false,
    		contentType: false,
            data: data,
            success: function(res){
            	result(res)
            }
        })	
	}


}
