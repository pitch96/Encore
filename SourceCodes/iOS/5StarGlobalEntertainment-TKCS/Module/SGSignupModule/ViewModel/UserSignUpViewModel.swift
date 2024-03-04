//
//  SignUpViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 22/11/22.
//

import Foundation
//import Alamofire
//
//class RegistrationViewModel : NSObject {
//    var registerModel : RegisterModel!
//
//    func callingSignupApi(registerParamDict: [String:String], completionHandler: @escaping(Bool)-> ()) {
//        AF.request("" , method: .post,  parameters: registerParamDict, encoding: JSONEncoding.default).response{ response in
//            debugPrint(response)
//            switch response.result{
//            case .success(let data):
//                do{
//                    self.registerModel = try JSONSerialization.jsonObject(with: data!, options: []) as? RegisterModel
//                    if response.response?.statusCode == 200{
//                        completionHandler(true)
//                    }else{
//                        completionHandler(false)
//                    }
////                    print(json)
//                }catch{
//                    print(error.localizedDescription)
//                    completionHandler(false)
//                }
//            case .failure(let err):
//                print(err.localizedDescription)
//                completionHandler(false)
//            }
//
//        }
//
//
//    }
//}
