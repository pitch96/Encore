//
//  FSGNetworkManager.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation
import Alamofire


struct FSGNetworkManager {
    let token = UserDefaults.standard.value(forKey: Tokenkey.userLogin) ?? ""
    func loginAuthetication(url:String,param:[String:Any],completion: @escaping((_ responseData:Data?)->Void),Error:@escaping((_ error:Error?)->Void), noInternet: @escaping((Bool?)->Void)){
        //        if Connectivity.isConnectedToInternet{
        AF.request(url, method: .post,parameters:param, headers: nil).responseData { response in
            switch response.result{
            case .success:
                switch response.response?.statusCode{
                case 200:
                    debugPrint(response)
                    completion(response.data)
                case 400:
                    completion(response.data)
                default:
                    let message = ""
                    let error = NSError(domain: "", code: response.response?.statusCode ?? 0, userInfo: [NSLocalizedDescriptionKey:message])  as Error
                    Error(error)
                }
            case .failure:
                Error(response.error)
            }
        }
        //        }
    }
        
    }

 
