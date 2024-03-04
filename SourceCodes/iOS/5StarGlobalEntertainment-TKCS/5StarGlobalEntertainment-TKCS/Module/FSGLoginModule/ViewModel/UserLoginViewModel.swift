//
//  UserLoginViewModel.swift
//  
//
//  Created by chetu on 25/11/22.
//

import Foundation

class UserLoginViewModel : NSObject{
    
    func callLogInUpApi(email: String, password: String,complition: @escaping (String?)->Void){
        var param: [String: Any] = [
            
            LoginApiParam.email: email,
            LoginApiParam.password: password
        ]
        Webservice.service(api: .login, param: param,service: .post) { (model: UserLoginModel, data, json) in
            if model.statusCode != 200{
                TokenService.sharedInstance.saveToken(token: model.token ?? DefaultValue.emptyString, key: Tokenkey.userLogin)
                complition(model.message)
            }else{
                complition(nil)
            }
            print(json)
        }
        
    }
    
}
