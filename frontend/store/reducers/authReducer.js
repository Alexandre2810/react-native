import { REGISTER_FAIL, REGISTER_SUCCESS } from "../types/authType";
import deCodeToken from "jwt-decode";

const authState = {
    loading : true,
    authenticate : false,
    error : "",
    successMessage : "",
    myInfo : ""
}

const tokenDecode = (token) => { 
    const expTime = newDate(deCodeToken(token).exp*1000);
    if (new Date() > expTime) return null;
    return deCodeToken(token);
}

export const authReducer = ( state = authState, action ) => {
    const {payload, type} = action;
    if(type === REGISTER_FAIL){
        return {
            ...state,
            error : payload.error,
            authenticate : false,
            myInfo : "",
            loading : true
        }
    }
    if( type === REGISTER_SUCCESS ){
        const myInfo = tokenDecode(payload.token);
        return{
            ...state,
            authenticate : true,
            loading : false,
            myInfo : myInfo,
            successMessage : payload.successMessage,
            error : ""
        }

    }
    return state;
}