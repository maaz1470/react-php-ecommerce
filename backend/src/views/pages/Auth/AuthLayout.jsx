/* eslint-disable prettier/prettier */
/* eslint-disable react/prop-types */
import React, { useContext } from 'react';
import { Navigate, Outlet } from 'react-router-dom';
import { AuthContext } from 'src/Provider/AuthProvider';

const AuthLayout = ({children}) => {
    const {auth} = useContext(AuthContext)
    if(auth){
        return <Navigate to={'/'} />
    }
    return (
        <div>
            <Outlet />
        </div>
    );
};

export default AuthLayout;