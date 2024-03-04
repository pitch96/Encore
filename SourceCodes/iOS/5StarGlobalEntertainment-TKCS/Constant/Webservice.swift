//
//  Webservice.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 26/11/22.
//

import Foundation
import Network
import UIKit

struct Media {
    var key: String
    let filename: String
    let data: Data
    let mimeType: String
    var img: UIImage

    init?(withImage image: UIImage, forKey key: String) {
        self.key = key
        self.mimeType = "image/jpg"
        self.filename = "\(Date().timeIntervalSince1970)imagefile.jpg"
        guard let data = image.jpegData(compressionQuality: 0.7) else { return nil }
        self.data = data
        self.img = image
    }
}
class Webservice{
    static func createDataBody(withParameters params: [String: Any]?, media: [Media]?, boundary: String) -> Data {
        let lineBreak = "\r\n"
        var body = Data()
        if let parameters = params {
            for (key, value) in parameters {
                body.append("--\(boundary + lineBreak)")
                body.append("Content-Disposition: form-data; name=\"\(key)\"\(lineBreak + lineBreak)")
                body.append("\(value)")
                body.append("\(lineBreak)")
            }
        }
        if let media = media {
            for photo in media {
                body.append("--\(boundary + lineBreak)")
                body.append("Content-Disposition: form-data; name=\"\(photo.key)\"; filename=\"\(photo.filename)\"\(lineBreak)")
                body.append("Content-Type: \(photo.mimeType + lineBreak + lineBreak)")
                body.append(photo.data)
                body.append(lineBreak)
            }
        }
        body.append("--\(boundary)--\(lineBreak)")
        return body
    }
    
    static func createDataBodyArray(withParameters params: [[String: Any]]?, media: [Media]?, boundary: String) -> Data {
        let lineBreak = "\r\n"
        var body = Data()
        if let parameters = params {
            for data in parameters {
                for (key, value) in data {
                    body.append("--\(boundary + lineBreak)")
                    body.append("Content-Disposition: form-data; name=\"\(key)\"\(lineBreak + lineBreak)")
                    body.append("\(value)")
                    body.append("\(lineBreak)")
                }
            }
        }
        if let media = media {
            for photo in media {
                body.append("--\(boundary + lineBreak)")
                body.append("Content-Disposition: form-data; name=\"\(photo.key)\"; filename=\"\(photo.filename)\"\(lineBreak)")
                body.append("Content-Type: \(photo.mimeType + lineBreak + lineBreak)")
                body.append(photo.data)
                body.append(lineBreak)
            }
        }
        body.append("--\(boundary)--\(lineBreak)")
        return body
    }
    
    func generateBoundary() -> String {
        return "Boundary-\(NSUUID().uuidString)"
    }
    
    //Generic function to call APIs
    static func service<Model: Codable>(api: API, urlAppendId: Any? = nil, param: Any? = nil, service: Service = .post,file: [Media]? = nil, onSuccess: @escaping((Model, Data, Any) -> Void)) {
        //        let boundary = "Boundary-\(UUID().uuidString)"
        
        //Check Internet Connection
        if Reachability.isConnectedToNetwork(){
            var fullUrlString = baseURL + api.rawValue
            if let idAppend = urlAppendId{
                fullUrlString = baseURL + api.rawValue + "\(idAppend)"
                debugPrint(fullUrlString)
            }
            // MARK: Passing parameter for GET type Api--
            if service == .get{
                if let param = param{
                    if param is String{
                        fullUrlString.append("?")
                        fullUrlString += (param as! String)
                    }else if param is Dictionary<String,Any>{
                        fullUrlString += Webservice.getString(from: param as! Dictionary<String,Any>)
                        debugPrint(fullUrlString)
                    }else{
                        assertionFailure("Parameter must be dictonary or String")
                    }
                }
            }
            guard let encodedString = fullUrlString.addingPercentEncoding(withAllowedCharacters: .urlFragmentAllowed) else {return}
            var request = URLRequest(url: URL(string: encodedString)!,cachePolicy: URLRequest.CachePolicy.useProtocolCachePolicy, timeoutInterval: Double.infinity)
            request.httpMethod = service.rawValue
            
            // MARK: Passing token in Authorization
            if let authKey = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
                request.addValue("Bearer \(authKey ?? "")" , forHTTPHeaderField: "Authorization")
            }
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
                    }else if paramter is [String: Any]{
                        //set content type
                        if file?.count ?? 0 > 0 {
                            var dataBody = Data()
                            let boundary = "Boundary-\(NSUUID().uuidString)"
                            request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
                            dataBody = createDataBody(withParameters: paramter as? [String : Any], media: file, boundary: boundary)
                            request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
                            request.httpBody = dataBody
                        } else {
                            var jsonData:Data?
                            do {
                                jsonData = try JSONSerialization.data(
                                    withJSONObject: paramter,
                                    options: .prettyPrinted)
                            } catch {
                                debugPrint(error.localizedDescription)
                            }
                            request.httpBody = jsonData
                        }
                    } else if paramter is [[String: Any]] {
                        //set content type
                        if file?.count ?? 0 > 0 {
                            var dataBody = Data()
                            let boundary = "Boundary-\(NSUUID().uuidString)"
                            request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
                            dataBody = createDataBodyArray(withParameters: paramter as? [[String : Any]], media: file, boundary: boundary)
                            request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
                            request.httpBody = dataBody
                        } else {
                            var jsonData:Data?
                            do {
                                jsonData = try JSONSerialization.data(
                                    withJSONObject: paramter,
                                    options: .prettyPrinted)
                            } catch {
                                debugPrint(error.localizedDescription)
                            }
                            request.httpBody = jsonData
                        }
                    }else {
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
                if err == nil {
                    if let responce = data {
                        do{
                            let jsonSer = try JSONSerialization.jsonObject(with: responce, options: .mutableContainers) as! [String: Any]
                            debugPrint(jsonSer)
                            
                            if jsonSer["message"] as? String ?? "" == "Token is Expired" {
                                
                                DispatchQueue.main.async {
                                    
                                    let refreshAlert = UIAlertController(title: Alert.projectName, message: "Session has been expired", preferredStyle: UIAlertController.Style.alert)
                                    refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                                        
                                        AppDelegate.sharedInstance.showLogin()
                                        
                                        
                                    }))
                                    if let window = UIApplication.shared.connectedScenes
                                        .filter({$0.activationState == .foregroundActive})
                                        .compactMap({$0 as? UIWindowScene})
                                        .first?.windows
                                        .filter({$0.isKeyWindow}).first{
                                        window.rootViewController!.present(refreshAlert, animated: true)
                                    }
                                }
                              
                            }else{
                                // MARK: Decoding Responce in as per model if API Succeed
                                let responceData = try JSONDecoder().decode(Model.self, from: responce)
                                
                                DispatchQueue.main.async {
                                    debugPrint(responceData)
                                    onSuccess(responceData, responce, jsonSer)
                                }
                            }
                        }
                        catch{
                            debugPrint(error.localizedDescription)
                        }
                    }
                }
                
                
            }.resume()
        }else{
            if let window = UIApplication.shared.connectedScenes
                .filter({$0.activationState == .foregroundActive})
                .compactMap({$0 as? UIWindowScene})
                .first?.windows
                .filter({$0.isKeyWindow}).first{
                window.rootViewController!.showToast(message: "Please check your internet connection")
            }
        }
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

extension Webservice {
    
    static func createDataBody1(withParameters params: [[String: Any]]?, media: [Media]?, boundary: String) -> Data {
        let lineBreak = "\r\n"
        var body = Data()
        for arrayDic in params ?? [[:]] {
            //if let parameters = arrayDic  {
                for (key, value) in arrayDic {
                    body.append("--\(boundary + lineBreak)")
                    body.append("Content-Disposition: form-data; name=\"\(key)\"\(lineBreak + lineBreak)")
                    body.append("\(value)")
                    body.append("\(lineBreak)")
                }
           // }
        }
        
        if let media = media {
            for photo in media {
                body.append("--\(boundary + lineBreak)")
                body.append("Content-Disposition: form-data; name=\"\(photo.key)\"; filename=\"\(photo.filename)\"\(lineBreak)")
                body.append("Content-Type: \(photo.mimeType + lineBreak + lineBreak)")
                body.append(photo.data)
                body.append(lineBreak)
            }
        }
        body.append("--\(boundary)--\(lineBreak)")
        if let json = try? JSONSerialization.jsonObject(with: body, options: .mutableContainers),
           let jsonData = try? JSONSerialization.data(withJSONObject: json, options: .prettyPrinted) {
            print(String(decoding: jsonData, as: UTF8.self))
        } else {
            print("json data malformed")
        }
        return body
    }
    
    //Generic function to call APIs
    static func service1<Model: Codable>(api: API, urlAppendId: Any? = nil, param: Any? = nil, service: Service = .post,file: [Media]? = nil, onSuccess: @escaping((Model, Data, Any) -> Void)) {
        //        let boundary = "Boundary-\(UUID().uuidString)"
        
        //Check Internet Connection
        if Reachability.isConnectedToNetwork(){
            
            var fullUrlString = baseURL + api.rawValue
            
            if let idAppend = urlAppendId{
                fullUrlString = baseURL + api.rawValue + "\(idAppend)"
                debugPrint(fullUrlString)
            }
            // MARK: Passing parameter for GET type Api
            if service == .get{
                if let param = param{
                    if param is String{
                        fullUrlString.append("?")
                        fullUrlString += (param as! String)
                    }else if param is Dictionary<String,Any>{
                        fullUrlString += Webservice.getString(from: param as! Dictionary<String,Any>)
                        debugPrint(fullUrlString)
                    }else{
                        assertionFailure("Parameter must be dictonary or String")
                    }
                }
            }
            guard let encodedString = fullUrlString.addingPercentEncoding(withAllowedCharacters: .urlFragmentAllowed) else {return}
            var request = URLRequest(url: URL(string: encodedString)!,cachePolicy: URLRequest.CachePolicy.useProtocolCachePolicy, timeoutInterval: Double.infinity)
            request.httpMethod = service.rawValue
            
            // MARK: Passing token in Authorization
            if let authKey = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
                request.addValue("Bearer \(authKey ?? "")" , forHTTPHeaderField: "Authorization")
            }
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
                    }else if paramter is Dictionary<String, Any> {
                       
                        //set content type
                        if file?.count ?? 0 > 0 {
                            var dataBody = Data()
                            let boundary = "Boundary-\(NSUUID().uuidString)"
                            request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
                            dataBody = createDataBody1(withParameters: paramter as? [[String : Any]], media: file, boundary: boundary)
                            request.setValue("multipart/form-data; boundary=\(boundary)", forHTTPHeaderField: "Content-Type")
                            request.httpBody = dataBody
                        } else {
                            var jsonData:Data?
                            do {
                                jsonData = try JSONSerialization.data(
                                    withJSONObject: paramter,
                                    options: .prettyPrinted)
                            } catch {
                                debugPrint(error.localizedDescription)
                            }
                            request.httpBody = jsonData
                        }
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
                if err == nil {
                    if let responce = data {
                        do{
                            let jsonSer = try JSONSerialization.jsonObject(with: responce, options: .mutableContainers) as! [String: Any]
                            debugPrint(jsonSer)
                            
                            if jsonSer["message"] as? String ?? "" == "Token is Expired" {
                                
                                DispatchQueue.main.async {
                                    
                                    let refreshAlert = UIAlertController(title: Alert.projectName, message: "Session has been expired", preferredStyle: UIAlertController.Style.alert)
                                    refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                                        
                                        AppDelegate.sharedInstance.showLogin()
                                        
                                        
                                    }))
                                    if let window = UIApplication.shared.connectedScenes
                                        .filter({$0.activationState == .foregroundActive})
                                        .compactMap({$0 as? UIWindowScene})
                                        .first?.windows
                                        .filter({$0.isKeyWindow}).first{
                                        window.rootViewController!.present(refreshAlert, animated: true)
                                    }
                                }
                              
                            }else{
                                // MARK: Decoding Responce in as per model if API Succeed
                                let responceData = try JSONDecoder().decode(Model.self, from: responce)
                                
                                DispatchQueue.main.async {
                                    debugPrint(responceData)
                                    onSuccess(responceData, responce, jsonSer)
                                }
                            }
                            
                            
                        }
                        catch{
                            debugPrint(error.localizedDescription)
                        }
                    }
                }
                
                
            }.resume()
        }else{
            if let window = UIApplication.shared.connectedScenes
                .filter({$0.activationState == .foregroundActive})
                .compactMap({$0 as? UIWindowScene})
                .first?.windows
                .filter({$0.isKeyWindow}).first{
                window.rootViewController!.showToast(message: "Please check your internet connection")
            }
        }
    }
}
