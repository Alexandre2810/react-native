// In App.js in a new project

import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { StyleSheet, Text, View } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

import Register from "./components/Register";
import Login from "./components/Register";
import { Provider } from 'react-redux';
import store from "./store/index";

const Stack = createStackNavigator();
const Tab = createBottomTabNavigator();



  

function mainStack(){
  return(
    <Stack.Navigator
      headerMode="none"
      navigationOptions = {{
        headerVisible: false,
      }}
    >
      <Stack.Screen name="Login" component={Login} />
      <Stack.Screen name="Register" component={Register} />
    </Stack.Navigator>
  )
}

function myTabs(){
  return(
    <Tab.Navigator>
      <Tab.Screen name="Login" component={Login} />
      <Tab.Screen name="Register" component={Register} />
    </Tab.Navigator>
  );
}

const App = ()=>{
  return(
    
<Provider store={store}>
  <NavigationContainer>
    {mainStack(), myTabs()}
  </NavigationContainer>
</Provider>
  );
}

export default App;