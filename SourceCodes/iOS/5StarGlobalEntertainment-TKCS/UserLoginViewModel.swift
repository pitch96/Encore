//
//  UserLoginViewModel.swift
//  
//
//  Created by chetu on 25/11/22.
//

import Foundation
class LoginViewModel: NSObject {
    
   
//    var logoutResponseModel : LogoutResponseModel!
    
    // MARK: - WEB SERVICES -
//    func callingLogoutAPI(completionHandler : @escaping (_ success : Bool, _ result : LogoutResponseModel?) -> Void){
//        let headers = ["token" : "\(TokenService.sharedInstance.getToken(key: TokenKey.userLogin))"]
//        let url = MtLogoutUrl + (UserDefaults.standard.string(forKey: MtCurrentLanguage)  ?? "en")
//        AF.request(url, method: .get, parameters: headers, encoding:URLEncoding.default, headers: nil).response{ response in
//            switch response.result{
//            case .success(let data):
//                do {
//                    self.logoutResponseModel = try JSONDecoder().decode(LogoutResponseModel.self, from: data!)
//                    TokenService.sharedInstance.removeUserDeafult(key: TokenKey.userLogin)
//                    TokenService.sharedInstance.removeUserDeafult(key: UserType.loginUser)
//
//                    if response.response?.statusCode == 200{
//                        completionHandler(true, self.logoutResponseModel)
//                    }
//                    else{
//                        completionHandler(false, self.logoutResponseModel)
//                    }
//                }catch{
//                    debugPrint(error.localizedDescription)
//                    completionHandler(false, nil)
//                }
//            case .failure(let err):
//                debugPrint(err.localizedDescription)
//                completionHandler(false, nil)
//            }
//        }
//    }
    
}
class LoginViewModell{
    weak var controller : UIViewController?
    init(controller : UIViewController) {
        self.controller = controller
    }
   
    func callloginAutheticationAPI(param:[String:Any],completion: @escaping((_ responseData:LoginResponseModel?, Bool)->Void),Error:@escaping((_ error:Error?)->Void)){
        controller?.startIndicatingActivity()
        MTLoginNetworkManager().loginAuthetication(param: param, completion: { responseData in
            self.controller?.stopIndicatingActivity()
              do{
                  let jsonDecoder = JSONDecoder()
                  let userResponse =  try jsonDecoder.decode(LoginResponseModel.self, from: responseData!)
                  let storeToken = userResponse.token
                  TokenService.sharedInstance.saveToken(token: storeToken ?? "", key: TokenKey.userLogin)
                  let saveUserType = userResponse.userType
                  TokenService.sharedInstance.saveUserType(type: saveUserType ?? "", key: UserType.loginUser)
                  let userName = userResponse.userName
                  TokenService.sharedInstance.saveUserType(type: userName ?? "", key: UserType.userName)
                  debugPrint(userResponse)
                  if userResponse.success ?? false {
                      completion(userResponse, true)
                  }else{
                      completion(userResponse, false)
                  }
              }catch let error {
                  debugPrint(error)
                  Error(error)
              }
          }, Error: { error in
              self.controller?.stopIndicatingActivity()
                Error(error)
            }, noInternet: { status in
              self.controller?.stopIndicatingActivity()
                 if status ?? false {
                     
              }
          })
  }
}
 
