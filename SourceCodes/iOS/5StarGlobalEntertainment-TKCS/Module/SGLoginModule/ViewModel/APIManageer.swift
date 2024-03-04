//
//  APIManageer.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//
import Foundation
//import Alamofire
//import Reachability
//import XCTest

//enum APIErrors: Error{
//    case custom(message: String)
//}
//typealias Handler
//= (Swift.Result<Any, APIErrors>) -> Void

//class APIManager{
//    
//    static let sharedInstance = APIManager()
//    var login : LoginModel! = nil
//    var logout : LogoutModel! = nil
//    
//    func callingLoginApi(email:String, password:String ,completionHandler : @escaping (_ success: Bool, _ Result : LoginModel?)->Void) {
//        
//        var param = [String:Any]()
//        param["email"] = email
//        param["password"] = password
//        AF.request("" , method: .post,  parameters: param, encoding: JSONEncoding.default).response{ response in
//            debugPrint(response)
//            switch response.result{
//            case .success(let data):
//                print(data)
//                do{
//                    
//                    self.login = try JSONDecoder().decode(LoginModel.self, from: data!)
//                    TokenService.tokenInstance.saveToken(token: self.login.token ?? "", key: TokenKey.userLogin )
//                    let tokenGen = TokenService.tokenInstance.getToken(key: TokenKey.userLogin)
//                    print(tokenGen)
//                    // print(json)
//                    if response.response?.statusCode == 200{
//                        completionHandler(true,self.login)
//                        
//                        
//                    }
//                    else{
//                        completionHandler(false,self.login)
//                    }
//                    
//                }catch{
//                    print(error.localizedDescription)
//                    completionHandler(false,nil)
//                }
//                
//            case .failure(let err):
//                print(err.localizedDescription)
//                completionHandler(false,nil)
//                
//            }
//        }
//    }
//    
//    func callingLogoutApi(completionHandler : @escaping (_ success : Bool, _ Result : LogoutModel? ) -> ()) {
//        let header = [
//            "token": "\(TokenService.tokenInstance.getToken(key: TokenKey.userLogin))"
//        ]
//        
//        AF.request("https://2mytickets-qa.chetu.com/api/logout", method: .get, parameters: header,encoding: URLEncoding.default, headers: nil).response{ response in
//            debugPrint(response)
//            switch response.result{
//            case .success(let data):
//                print(data)
//                do{
//                    self.logout = try JSONDecoder().decode(LogoutModel.self, from: data!)
//                    
//                    TokenService.tokenInstance.removeToken()
//                    //                    self.navigationController?.popViewController(animated: true)
//                    // print(json)
//                    if response.response?.statusCode == 200{
//                        completionHandler(true,self.logout)
//                        
//                        
//                    }
//                    else{
//                        completionHandler(false,self.logout)
//                    }
//                    
//                }catch{
//                    print(error.localizedDescription)
//                    completionHandler(false,nil)
//                }
//                
//            case .failure(let err):
//                print(err.localizedDescription)
//                completionHandler(false,nil)
//                
//            }
//        }
//    }
//    
//}
