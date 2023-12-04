/* eslint-disable prettier/prettier */
import 'react-app-polyfill/stable'
import 'core-js'
import './scss/style.scss'
import React from 'react'
import { createRoot } from 'react-dom/client'
// import App from './App'
import reportWebVitals from './reportWebVitals'
import { Provider } from 'react-redux'
import store from './store'
import { RouterProvider } from 'react-router-dom'
import router from './Routes/Routes'
import AuthProvider from './Provider/AuthProvider'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8000'

axios.interceptors.request.use(config => {
  const token = localStorage.getItem('__rh_token')
  config.headers.Authorization = token ? `Bearer ${token}` : '';
  return config;
})


createRoot(document.getElementById('root')).render(
  <Provider store={store}>
    <AuthProvider>
      <RouterProvider router={router} />
    </AuthProvider>
  </Provider>,
)

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals()
