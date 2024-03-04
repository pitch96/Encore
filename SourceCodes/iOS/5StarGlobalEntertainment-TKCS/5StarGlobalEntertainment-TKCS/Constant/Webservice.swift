//
//  Webservice.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 26/11/22.
//

import Foundation
import Network
import UIKit
 
class Webservice{
    //Generic function to call APIs
    static func service<Model: Codable>(api: API, urlAppendId: Any? = nil, param: Any? = nil, service: Service = .post, onSuccess: @escaping((Model, Data, Any) -> Void)) {
//        let boundary = "Boundary-\(UUID().uuidString)"
        
        //Check Internet Connection
//        if Reachability.isConnectedToNetwork(){
            
            var fullUrlString = baseURL + api.rawValue
            
            if let idAppend = urlAppendId{
                fullUrlString = baseURL + api.rawValue + "\(idAppend)"
                print(fullUrlString)
            }
  
            // MARK: Passing parameter for GET type Api
            if service == .get{
                if let param = param{
                    if param is String{
                        fullUrlString.append("?")
                        fullUrlString += (param as! String)
                    }else if param is Dictionary<String,Any>{
                        fullUrlString += self.getString(from: param as! Dictionary<String,Any>)
                        print(fullUrlString)
                    }else{
                        assertionFailure("Parameter must be dictonary or String")
                    }
                }
            }
            guard let encodedString = fullUrlString.addingPercentEncoding(withAllowedCharacters: .urlFragmentAllowed) else {return}
            var request = URLRequest(url: URL(string: encodedString)!,cachePolicy: URLRequest.CachePolicy.useProtocolCachePolicy, timeoutInterval: Double.infinity)
            request.httpMethod = service.rawValue
            
            // MARK: Passing token in Authorization
//            if let authKey = UserDefaults.standard.string(forKey: AppString.authkey.rawValue){
//                request.addValue("Bearer \(authKey)" , forHTTPHeaderField: "Authorization")
//            }
            
            request.addValue("application/json", forHTTPHeaderField: "Content-Type") // change as per server requirements
            request.addValue("application/json", forHTTPHeaderField: "Accept")
            
            let sessionConfig = URLSessionConfiguration.default
            let session = URLSession(configuration: sessionConfig)
         
            // MARK: Passing parameter for DELETE type Api
            if service == .delete{
                if let param = param{
                    if param is String{
                        let postData = NSMutableData(data: (param as! String).data(using: .utf8)!)
                        request.httpBody = postData as Data
                    }
                }
            }
            
            // MARK: Passing parameter for PUT AND POST type Api
            if service == .put || service == .post{
                if let paramter = param{
                    if paramter is String{
                        request.httpBody = (paramter as! String).data(using: .utf8)
                    }else if paramter is Dictionary<String, Any>{
                        var jsonData:Data?
                        do {
                            jsonData = try JSONSerialization.data(
                              withJSONObject: paramter,
                              options: .prettyPrinted)
                        } catch {
                            print(error.localizedDescription)
                        }
                        request.httpBody = jsonData
                    }else{
                        assertionFailure("Parameter must be a String or Dictonary")
                    }
                }
            }
            
            // MARK: Start Showing Activity Indicator
            DispatchQueue.main.async {
                if let window = UIApplication.shared.connectedScenes
                    .filter({$0.activationState == .foregroundActive})
                    .compactMap({$0 as? UIWindowScene})
                    .first?.windows
                    .filter({$0.isKeyWindow}).first{
                    window.rootViewController!.startIndicatingActivity()
                }
            }
            
            session.dataTask(with: request) { data, jsonResponce, err in
                // MARK: Stop Showing Activity Indicator
                DispatchQueue.main.async {
                    if let window = UIApplication.shared.connectedScenes
                        .filter({$0.activationState == .foregroundActive})
                        .compactMap({$0 as? UIWindowScene})
                        .first?.windows
                        .filter({$0.isKeyWindow}).first{
                        window.rootViewController!.stopIndicatingActivity()
                    }
                }
                
                if err == nil{
                    if let responce = data{
                        do{
                            let jsonSer = try JSONSerialization.jsonObject(with: responce, options: .mutableContainers) as! [String: Any]
                            print(jsonSer)
                            
                            // MARK: Decoding Responce in as per model if API Succeed
//                            if jsonSer["status"] as! Bool == true {
                                let responceData = try JSONDecoder().decode(Model.self, from: responce)
                                DispatchQueue.main.async {
                                    onSuccess(responceData, responce, jsonSer)
                                }
//                            }else{
//                                DispatchQueue.main.async {
//                                    if let window = UIApplication.shared.connectedScenes
//                                        .filter({$0.activationState == .foregroundActive})
//                                        .compactMap({$0 as? UIWindowScene})
//                                        .first?.windows
//                                        .filter({$0.isKeyWindow}).first{
//                                        window.rootViewController!.showToast(message: jsonSer["message"] as! String)
//                                    }
//                                }
//                            }
                            
                        }
                        catch{
          
                            print(error.localizedDescription)
                        }
                    }
                }
            }.resume()
//        }else{
//            if let window = UIApplication.shared.connectedScenes
//                .filter({$0.activationState == .foregroundActive})
//                .compactMap({$0 as? UIWindowScene})
//                .first?.windows
//                .filter({$0.isKeyWindow}).first{
//                window.rootViewController!.showToast(message: "Please check your internet connection")
//            }
//        }
    }
    
    // MARK: Function to convert dictonary into string
    private static func getString(from dict: Dictionary<String, Any>) -> String{
        var stringDict = String()
        stringDict.append("?")
        for (key,value) in dict{
            let param = key + "=" + "\(value)"
            stringDict.append(param)
            stringDict.append("&")
        }
        stringDict.removeLast()
        return stringDict
    }
}
extension Data{
    mutating public func append(_ string: String) {
        if let data = string.data(using: .utf8){
            append(data)
        }
    }
}
 
