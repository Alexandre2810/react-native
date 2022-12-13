import { compose, applyMiddleware, combineReducers } from 'redux';
import { configureStore } from '@reduxjs/toolkit'
import thunkMiddleware from 'redux-thunk';
import { authReducer } from './reducers/authReducer';

const rootReducer = combineReducers({
    auth : authReducer
})

const middleware = [thunkMiddleware];

const store = configureStore({reducer: rootReducer}, compose(applyMiddleware(...middleware),
window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__() ));

export default store;