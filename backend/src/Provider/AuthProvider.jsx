/* eslint-disable prettier/prettier */
/* eslint-disable react/prop-types */


import axios from 'axios'
import React, { createContext, useEffect, useState } from 'react'
import server_url from 'src/hook/useServerURL'

export const AuthContext = createContext(null)

const AuthProvider = ({ children }) => {
    const [auth, setAuth] = useState(false)
    const [loading, setLoading] = useState(true);
    const getAuth = async () => {
        await axios.get(`${server_url}/authCheck`).then(response => {
            if(response.data.status === 200){
                setAuth(true)
            }else if(response.data.status === 401){
                setAuth(false)
            }else{
                setAuth(false)
            }
            setLoading(false)
        })
    }
    useEffect(() => {
        getAuth();
        return () => getAuth();
    },[])

    const userInfo = {
        auth,
        loading,
        getAuth
    }
    return (
        <AuthContext.Provider value={userInfo}>
            {children}
        </AuthContext.Provider>
    );
}

export default AuthProvider
