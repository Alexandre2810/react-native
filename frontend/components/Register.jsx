import {useState, useEffect} from 'react';
import {Link} from 'react-router-native'
import {
    Alert,
    KeyboardAvoidingView,
    Platform,
    Pressable,
    SafeAreaView,
    StyleSheet,
    Text,
    TextInput,
    TouchableOpacity,
    View,
} from 'react-native';
import routes from "../conf/routes";
import { useDispatch, useSelector } from 'react-redux';
import { userRegister } from '../store/actions/authAction';
import { ERROR_CLEAR, SUCCESS_MESSAGE_CLEAR } from '../store/types/authType';

const Register = () => {
const styles = StyleSheet.create({
    container: {
        flex: 1,
        padding: 24,
        backgroundColor: "#eaeaea"
    },
    title: {
        marginTop: 16,
        paddingVertical: 8,
        borderWidth: 4,
        borderColor: "#20232a",
        borderRadius: 6,
        backgroundColor: "#61dafb",
        color: "#20232a",
        textAlign: "center",
        fontSize: 30,
        fontWeight: "bold"
    }
    });
    
    const alert = (name, message)=>{
        return Alert.alert(name, message);
    };
    
    const {loading,authenticate,error,successMessage,myInfo} = useSelector(state => state.auth);

    const dispatch = useDispatch();

    const [state, setState] = useState({
        userName: "",
        email: "",
        password: "",
        confirmPassword: "",
        image: "",
        tos: false
    });

    const [loadImage, setLoadImage] = useState("");

    const inputHandler = e =>{
        setState({
            ...state,
            [e.target.name] : e.target.value
        });
    }

    const fileHandler = e => {
        if (e.target.files.length !== 0){
            setState({
                ...state,
                [e.target.name] : e.target.files[0]
            })
        }

        const reader = new FileReader();
        reader.onload = () => {
            setLoadImage(reader.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    }

    const register = e => {
        e.preventDefault();

        const formData = new FormData();

        formData.append("userName", state.userName);
        formData.append("password", state.password);
        formData.append("confirmPassword", state.confirmPassword);
        formData.append("email", state.email);
        formData.append("tos", state.tos);
        formData.append("image", state.image);

        dispatch(userRegister(formData));

        console.log(state);
    }

    useEffect(()=>{
        if(authenticate) navigate('/');
        if(successMessage){
             alert("Success",successMessage);
             dispatch({type : SUCCESS_MESSAGE_CLEAR })
        }
        if(error){
             error.map(err=>alert("Error", err));
             dispatch({type : ERROR_CLEAR })
        }
    },[successMessage,error])

    return (
        <View style={styles.root}>
            <SafeAreaView style={styles.safeAreaView}>
                <KeyboardAvoidingView
                    style={styles.content}
                >
                    <Text style={styles.title}></Text>


                    <Text style={styles.subtitle}></Text>


                    <Pressable>
                        <View style={styles.form}>
                            <Text style={styles.label}></Text>

                            <TextInput
                                autoCapitalize="none"
                                autoCompleteType="text"
                                autoCorrect={false}
                                keyboardType="text"
                                returnKeyType="next"
                                style={styles.textInput}
                                textContentType="username"
                                onChangeText={inputHandler}
                            />
                        </View>
                    </Pressable>

                    <Pressable>
                        <View style={styles.form}>
                            <Text style={styles.label}></Text>

                            <TextInput
                                autoCapitalize="none"
                                autoCompleteType="password"
                                autoCorrect={false}
                                returnKeyType="done"
                                secureTextEntry
                                style={styles.textInput}
                                textContentType="password"
                                onChangeText={inputHandler}
                            />
                        </View>
                    </Pressable>

                    <TouchableOpacity
                        onPress={(e) => submit(e)}
                    >
                        <View style={styles.button}>
                            <Text style={styles.buttonTitle}>Inscription</Text>
                        </View>
                    </TouchableOpacity>
                </KeyboardAvoidingView>
            </SafeAreaView>
        </View>
    )
};

export default Register;