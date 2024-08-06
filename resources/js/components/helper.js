import toastr from "toastr"

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
    }

}