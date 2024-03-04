//
//  SignUpViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 22/11/22.
//
import UIKit
import Foundation

class UserSignUpViewModel : NSObject{
    // MARK: Create function for call sign Up API--
    func callSignUpApi(fName: String, lName: String, email: String, phoneNum: String, companyName: String, pass: String, confirmPass: String, userType: String,complition: @escaping(UserSignUpModel?, Bool)->Void){
        let param: [String: Any] = [
            SignUpApiParam.user_type : userType,
            SignUpApiParam.first_name : fName,
            SignUpApiParam.last_name : lName,
            SignUpApiParam.email : email,
            SignUpApiParam.phone_no : phoneNum,
            SignUpApiParam.company_name : companyName,
            SignUpApiParam.password : pass,
            SignUpApiParam.password_confirmation : confirmPass
        ]
        Webservice.service(api: .register, param: param,service: .post) { (model: UserSignUpModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}
