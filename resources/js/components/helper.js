import toastr from "toastr";
import lang from '../lang.json';

export default {

    renderError(error) {
        let message = error;

        console.log(error)

        if(error.response) {
            if(error.response.data) {
                message = error.response.data.message;
            }
        }

        console.error(message);
        toastr.error(message)
    },


    label(snakeCaseString){
        if(lang[snakeCaseString]) {
            return lang[snakeCaseString];
        }
        return snakeCaseString
        .split('_')                  // Split the string by underscores
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
        .join(' '); 
    }

}