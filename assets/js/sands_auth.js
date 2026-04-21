function validateJWT(action, jwtoken_name, controller, formData)
{
    return new Promise((resolve, reject) => {

        const token = localStorage.getItem(jwtoken_name);

        if(!token){
            resolve({status:false, message:"No token"});
            return;
        }

        $.ajax({
            url: "/" + controller,
            type: "POST",
            data: {
                action: action,
                jwt_token: token,
                formData: JSON.stringify(formData)
            },
            success: function(response)
            {
                try {
                    let res = JSON.parse(response);
                    resolve(res);
                } catch(e) {
                    reject(e);
                }
            },
            error: function(){
                reject("AJAX Error");
            }
        });

    });
}

async function checkJWT(action,token,controller,formdata) {
            try {
                let res = await validateJWT(action,token,controller,formdata);
    
                if(res.status){
                    //console.log("Success:", res);
                    setupDropdown('dropdownContent','success',svgSuccess+res.message,'click');
                    return res;
                } else {
                    //console.log("Failed:", res.message);
                    setupDropdown('dropdownContent','error',svgSuccess+res.message,'click');
                }
    
            } catch(err) {
                //console.error("Error:", err);
                setupDropdown('dropdownContent','error',svgSuccess+err,'click');
            }
}
        