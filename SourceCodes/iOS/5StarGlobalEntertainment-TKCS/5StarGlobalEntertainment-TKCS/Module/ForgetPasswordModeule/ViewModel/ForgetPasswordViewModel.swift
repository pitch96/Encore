//
//  ForgetPasswordViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import Foundation

class ForgetPasswordViewModel : NSObject{
    
    func callForgetPasswordApi(email: String,complition: @escaping (ForgetPasswordModel?)->Void){
        var param: [String: Any] = [
            
            LoginApiParam.email: email
            
        ]
        Webservice.service(api: .forgetPassword, param: param,service: .post) { (model: ForgetPasswordModel, data, json) in
            
            do {
                    let data = try JSONDecoder().decode(ForgetPasswordModel.self, from: data)
                    debugPrint(data)
                    complition(data)
            }catch{
                debugPrint(data)
            }
//            if model.statusCode == 200{
//                complition(model.message)
//            }else{
//                complition(nil)
//            }
//            print(json)
        }
        
    }
}
