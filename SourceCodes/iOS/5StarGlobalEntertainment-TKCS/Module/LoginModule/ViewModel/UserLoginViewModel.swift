//
//  UserLoginViewModel.swift
//  
//
//  Created by chetu on 25/11/22.
//

import Foundation

class UserLoginViewModel : NSObject{
    // MARK: Create function for call Login API--
    func callLogInUpApi(email: String, password: String,complition: @escaping (LoginModel?, Bool)->Void){
        let param: [String: Any] = [
            LoginApiParam.email: email,
            LoginApiParam.password: password
        ]
        Webservice.service(api: .login, param: param,service: .post) { [weak self](model: LoginModel, data, json) in
            if model.statusCode == 200{
                UserDefaults.standard.set(model.token ?? DefaultValue.emptyString.rawValue, forKey: Tokenkey.userLogin)
                UserDefaults.standard.setValue(model.data?.userType ?? 0, forKey: Tokenkey.UsersTypes)
                UserDefaults.standard.setValue(model.data?.id ?? 0, forKey: DefaultValue.UserID.rawValue)
                complition(model, true)
                
            }else{
                complition(model, false)
            }
                
        }
        
    }
}
