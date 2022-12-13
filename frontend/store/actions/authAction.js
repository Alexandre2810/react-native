import axios from 'axios';
import {  REGISTER_FAIL, REGISTER_SUCCESS } from "../types/authType";

export const userRegister = (data) =>{
    return async (dispatch) => {
        const config = {
            headers : {
                'Content-Type':'application/json'
            }
        }
        try{
            // redirection vers backend en passant la data (le formulaire)
            const response = await axios.post("/api/messenger/user-register",data,config); 
            localStorage.setItem("authToken", response.data.token);

            dispatch({
                type : REGISTER_SUCCESS,
                payload : {
                    successMessage: response.data.successMessage,
                    token : response.data.token
                }
            })
        } catch (error){
            // erreur survenue lors du traitement
            dispatch({
                    type : REGISTER_FAIL,
                    payload : {
                        error : error.response.data.error.errorMessage
                    }
            })
        }
    }   
}