//
//  ResetPasswordViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import Foundation

class ResetPasswordViewModel{
    func resetPasswordApi(otp: String,email: String,password: String,confirm_password: String,complition: @escaping (ResetPasswordModel?)->Void){
        
        let param: [String:Any] = [
            ResetPasswordApiParam.otp : otp,
            ResetPasswordApiParam.email : email,
            ResetPasswordApiParam.password : password,
            ResetPasswordApiParam.password_confirmation : confirm_password
        ]
        Webservice.service(api: .resetPassword, param: param,service: .post) { (model: ResetPasswordModel, data, json) in
            complition(model)
        }
        
    }
    func resendPasswordApi(email: String,complition: @escaping (ResendPassword?)->Void){
        let param: [String:Any] = [
            ResendOtpApiParam.email : email
        ]        
        Webservice.service(api: .resendOTP, param: param,service: .post) { (model: ResendPassword, data, json) in
            complition(model)

        }
        
    }
}
