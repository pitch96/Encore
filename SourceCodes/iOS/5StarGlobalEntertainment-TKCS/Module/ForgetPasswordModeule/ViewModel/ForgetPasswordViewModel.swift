//
//  ForgetPasswordViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import Foundation

class ForgetPasswordViewModel : NSObject{
    // MARK: Create function For forget Password API--
    func callForgetPasswordApi(email: String,complition: @escaping (ForgetPasswordModel?, Bool)->Void){
        let param: [String: Any] = [
            LoginApiParam.email: email
        ]
        Webservice.service(api: .forgetPassword, param: param,service: .post) { (model: ForgetPasswordModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model,false)
            }
        }
        
    }
}
