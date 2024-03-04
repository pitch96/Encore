//
//  WebServiceManager.swift
//  MetroPavia
//
//  Created by chetu on 08/12/21.
//

import UIKit
import Alamofire
//import SVProgressHUD

let objWebServiceManager = WebServiceManager.sharedObject()

var strAuthToken : String = ""

class Connectivity{
    class var isConnectedToInternet : Bool{
        return NetworkReachabilityManager()!.isReachable
    }
}

class WebServiceManager: NSObject {
    
    fileprivate var window = UIApplication.shared.connectedScenes.flatMap { ($0 as? UIWindowScene)?.windows ?? [] }.first { $0.isKeyWindow }
    
    private static var sharedWebServiceManager : WebServiceManager = {
        let webServiceManager = WebServiceManager()
        return webServiceManager
    }()
    
    class func sharedObject() -> WebServiceManager{
        return sharedWebServiceManager
    }
    
//    func showIndicator(){
//        SVProgressHUD.setDefaultStyle(.custom)
//        SVProgressHUD.setDefaultMaskType(.custom)
//        SVProgressHUD.setDefaultAnimationType(.flat)
//        SVProgressHUD.setBackgroundColor(UIColor.white)
//        SVProgressHUD.setRingThickness(5.0)
//        SVProgressHUD.setRingRadius(30.0)
//        SVProgressHUD.show()
//    }
    
//    func hideIndicator(){
//        SVProgressHUD.dismiss()
//    }
    
    func getCurrentTimeZone() -> String{
        return TimeZone.current.identifier
    }
    
    func queryString(_ value : String , params : [String : Any]) -> String?{
        var components = URLComponents(string: value)
        components?.queryItems = params.map { element in URLQueryItem(name: element.key, value: element.value as? String)}
        return components?.url?.absoluteString
    }
    
    func isNetworkAvailable() -> Bool{
        if !NetworkReachabilityManager()!.isReachable{
            return false
        }else{
            return true
        }
    }
    
    // MARK: Request Post method --
    
    public func requestPost(strUrl : String , params : [String : Any]? , queryParams : [String : Any], strCustomValidation : String , showIndicator : Bool , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
        
        strAuthToken = ""
        
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
        
        let currentTimeZone = getCurrentTimeZone()
        
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData ]
        var strCompleteUrl = ""
        
        if strCustomValidation == WsParamsType.PathVariable{
            let pathVariable = queryParams.PathString
            strCompleteUrl = "\(strUrl)" + pathVariable
            debugPrint("pathVariable...... \(pathVariable)")
        }else if strCustomValidation == WsParamsType.QueryParams{
            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
        }else{
            strCompleteUrl = strUrl
        }
        
        debugPrint("url..... \(strCompleteUrl)")
        debugPrint(params ?? [:])
//        debugPrint(headers)
        
        AF.request(strCompleteUrl, method: .post, parameters: params, encoding: JSONEncoding.default).responseJSON { responseObject in
            switch responseObject.result{
                
            case .success(_):
                do {
                    if let jsonData = responseObject.data{
                        success(jsonData)
                    }
                }
            case .failure(let encodingError):
                debugPrint("Error ", encodingError)
                failure(encodingError)
            }
        }
    }
    
    
    // MARK: Request Patch method --
    
//    public func requestPatch(strUrl : String , params : [String : Any]? , queryParams : [String : Any], strCustomValidation : String , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
//
//        strAuthToken = ""
//
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
//
//        let currentTimeZone = getCurrentTimeZone()
//
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData]
//        var strCompleteUrl = ""
//
//        if strCustomValidation == WsParamsType.PathVariable{
//            let pathVariable = queryParams.PathString
//            strCompleteUrl = "\(strUrl)" + pathVariable
//            debugPrint("pathVariable...... \(pathVariable)")
//        }else if strCustomValidation == WsParamsType.QueryParams{
//            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
//        }else{
//            strCompleteUrl = strUrl
//        }
//
//        debugPrint("url..... \(strCompleteUrl)")
//        debugPrint(params ?? [:])
//        debugPrint(headers)
//
//        AF.request(strCompleteUrl, method: .patch, parameters: params, encoding: JSONEncoding.default, headers: headers).responseJSON { responseObject in
//            switch responseObject.result{
//
//            case .success(_):
//                do {
//                    if let jsonData = responseObject.data{
//                        success(jsonData)
//                    }
//                }
//            case .failure(let encodingError):
//                debugPrint("Error ", encodingError)
//                failure(encodingError)
//            }
//        }
//    }
//
    // MARK: Request Put method --
    
//    public func requestPut(strUrl : String , params : [String : Any]? , queryParams : [String : Any], strCustomValidation : String , showIndicator : Bool , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
//
//        strAuthToken = ""
//
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
//
//        let currentTimeZone = getCurrentTimeZone()
//
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData  ]
//        var strCompleteUrl = ""
//
//        if strCustomValidation == WsParamsType.PathVariable{
//            let pathVariable = queryParams.PathString
//            strCompleteUrl = "\(strUrl)" + pathVariable
//            debugPrint("pathVariable...... \(pathVariable)")
//        }else if strCustomValidation == WsParamsType.QueryParams{
//            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
//        }else{
//            strCompleteUrl = strUrl
//        }
//
//        debugPrint("url..... \(strCompleteUrl)")
//        debugPrint(params ?? [:])
//        debugPrint(headers)
//
//        AF.request(strCompleteUrl, method: .put, parameters: params, encoding: JSONEncoding.default, headers: headers).responseJSON { responseObject in
//            switch responseObject.result{
//
//            case .success(_):
//                do {
//                    if let jsonData = responseObject.data{
//                        success(jsonData)
//                    }
//                }
//            case .failure(let encodingError):
//                debugPrint("Error ", encodingError)
//                failure(encodingError)
//            }
//        }
//    }
    

    
    // MARK: Request Get method --
    
    public func requestGet(strUrl : String , params : [String : Any]? , queryParams : [String : Any], strCustomValidation : String , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
        
        strAuthToken = ""
        
        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
            strAuthToken = "Bearear" + " " + token
        }
        
        let currentTimeZone = getCurrentTimeZone()
        
        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
                                     WsHeader.accept : WsHeader.applicationJson ,
                                     WsHeader.contentType : WsHeader.contentTypeData ]
        var strCompleteUrl = ""
        
        if strCustomValidation == WsParamsType.PathVariable{
            let pathVariable = queryParams.PathString
            strCompleteUrl = "\(strUrl)" + pathVariable
            debugPrint("pathVariable...... \(pathVariable)")
        }else if strCustomValidation == WsParamsType.QueryParams{
            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
        }else{
            strCompleteUrl = strUrl
        }
        
        debugPrint("url..... \(strCompleteUrl)")
        debugPrint(params ?? [:])
        debugPrint(headers)
        
        AF.request(strCompleteUrl, method: .get, parameters: params, encoding: URLEncoding.default, headers: headers).responseJSON { responseObject in
            
            switch responseObject.result{
            case .success(_):
                do {
                    if let jsonData = responseObject.data{
                        success(jsonData)
                    }
                }
            case .failure(let encodingError):
                debugPrint("Error ", encodingError)
                failure(encodingError)
            }
        }
    }
    
    // MARK: Request Delete method --
    
//    public func requestDelete(strUrl : String , params : [String : Any]? , queryParams : [String : Any], strCustomValidation : String , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
//
//        strAuthToken = ""
//
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
//
//        let currentTimeZone = getCurrentTimeZone()
//
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData ]
//        var strCompleteUrl = ""
//
//        if strCustomValidation == WsParamsType.PathVariable{
//            let pathVariable = queryParams.PathString
//            strCompleteUrl = "\(strUrl)" + pathVariable
//            debugPrint("pathVariable...... \(pathVariable)")
//        }else if strCustomValidation == WsParamsType.QueryParams{
//            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
//        }else{
//            strCompleteUrl = strUrl
//        }
//
//        debugPrint("url..... \(strCompleteUrl)")
//        debugPrint(params ?? [:])
//        debugPrint(headers)
//
//        AF.request(strCompleteUrl, method: .delete, parameters: params, encoding: JSONEncoding.default, headers: headers).responseJSON { responseObject in
//            switch responseObject.result{
//
//            case .success(_):
//                do {
//                    if let jsonData = responseObject.data{
//                        success(jsonData)
//                    }
//                }
//            case .failure(let encodingError):
//                debugPrint("Error ", encodingError)
//                failure(encodingError)
//            }
//        }
//    }
    
    // MARK: Request Upload MultipartData method --
    
//    public func requestPostUploadMultipartMultipleImagesData(strUrl : String , params : [String : Any]? , queryParams : [String : Any] , showIndicator : Bool , imagesData : Data? , imageToUplaod : [Data] , imagesParam : [String] , fileName : String? , mimeType : String? , strCustomValidation : String , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
//        if !NetworkReachabilityManager()!.isReachable{
//            let app = UIApplication.shared.delegate as? AppDelegate
//            let window = app?.window
//            debugPrint(window ?? "")
//            DispatchQueue.main.async {
//                objWebServiceManager.showIndicator()
//            }
//            return
//        }
//
//        strAuthToken = ""
//
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
//
//        let currentTimeZone = getCurrentTimeZone()
//
//
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData ,
//
//                                     WsHeader.deviceType : "" ,
//                                     WsHeader.deviceTimeZone : currentTimeZone ,
//                                     ]
//        var strCompleteUrl = ""
//
//        if strCustomValidation == WsParamsType.PathVariable{
//            let pathVariable = queryParams.PathString
//            strCompleteUrl = "\(strUrl)" + pathVariable
//            debugPrint("pathVariable...... \(pathVariable)")
//        }else if strCustomValidation == WsParamsType.QueryParams{
//            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
//        }else{
//            strCompleteUrl = strUrl
//        }
//
//        debugPrint("url..... \(strCompleteUrl)")
//        debugPrint(params ?? [:])
//        debugPrint(headers)
//
//        AF.upload(multipartFormData: { multipartFormData in
//            let userId = UserDefaults.standard.string(forKey: UserDefaults.KeysDefault.userId) ?? ""
//            let count = imageToUplaod.count
//            for i in 0..<count{
//                multipartFormData.append(imageToUplaod[i], withName: "\(imagesParam[i])", fileName: "file\(userId).png", mimeType: "image/*")
//            }
//            for (key, value) in params ?? [:]{
//                multipartFormData.append((value as AnyObject).data(using: String.Encoding.utf8.rawValue)! , withName: key)
//            }
//        }, to: strUrl , usingThreshold: UInt64.init() , method: .post , headers: headers).response{
//            response in
//            switch response.result{
//
//            case .success(_):
//                do{
//                    if let jsonData = response.data{
//                        success(jsonData)
//                    }
//                }
//            case .failure(let encodingError):
//                debugPrint("Error ", encodingError)
//                failure(encodingError)
//            }
//        }
//    }
    
    // MARK: Request Upload MultipartData File Upload method --
    
//    public func requestPostUploadMultipartFiles(strUrl : String , params : [String : String]? , queryParams : [String : Any] , showIndicator : Bool , fileData : Data? , fileToUplaod : [Data] , fileParam : [String] , fileName : String? , mimeType : String? , strCustomValidation : String , strDocumentExtension : String, success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
//        if !NetworkReachabilityManager()!.isReachable{
//            let app = UIApplication.shared.delegate as? AppDelegate
//            let window = app?.window
//            debugPrint(window ?? "")
//            DispatchQueue.main.async {
//                objWebServiceManager.showIndicator()
//            }
//            return
//        }
//
//        strAuthToken = ""
//
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
//
//        let currentTimeZone = getCurrentTimeZone()
//
//
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData ,
//
//                                     WsHeader.deviceType : "" ,
//                                     WsHeader.deviceTimeZone : currentTimeZone ,
//                                     ]
//        var strCompleteUrl = ""
//
//        if strCustomValidation == WsParamsType.PathVariable{
//            let pathVariable = queryParams.PathString
//            strCompleteUrl = "\(strUrl)" + pathVariable
//            debugPrint("pathVariable...... \(pathVariable)")
//        }else if strCustomValidation == WsParamsType.QueryParams{
//            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
//        }else{
//            strCompleteUrl = strUrl
//        }
//
//        debugPrint("url..... \(strCompleteUrl)")
//        debugPrint(params ?? [:])
//        debugPrint(headers)
//
//        AF.upload(multipartFormData: { multipartFormData in
//            let count = fileToUplaod.count
//            for i in 0..<count{
//                multipartFormData.append(fileToUplaod[i], withName: "\(fileParam[i])", fileName: "\(strDocumentExtension)", mimeType: "application/pdf")
//            }
//            for (key, value) in params ?? [:]{
//                multipartFormData.append((value as AnyObject).data(using: String.Encoding.utf8.rawValue)! , withName: key)
//            }
//        }, to:  strUrl)
//            .responseJSON {response in
//                switch response.result{
//
//                case .success(_):
//                    do{
//                        if let jsonData = response.data{
//                            success(jsonData)
//                        }
//                    }
//                case .failure(let encodingError):
//                    debugPrint("Error ", encodingError)
//                    failure(encodingError)
//                }
//            }
//    }
    
    // MARK: Request Upload MultipartData method --
    
//    public func requestPostUploadMultipartArray(strUrl : String , params : [String : Any]? , queryParams : [String : Any] , showIndicator : Bool , strCustomValidation : String , parameterKey : String , success : @escaping(Data) -> Void , failure : @escaping(Error) -> Void){
//        if !NetworkReachabilityManager()!.isReachable{
//            let app = UIApplication.shared.delegate as? AppDelegate
//            let window = app?.window
//            debugPrint(window ?? "")
//            DispatchQueue.main.async {
//                objWebServiceManager.showIndicator()
//            }
//            return
//        }
//
//        strAuthToken = ""
//
//        if let token = UserDefaults.standard.string(forKey: Tokenkey.userLogin){
//            strAuthToken = "Bearear" + " " + token
//        }
//
//        let currentTimeZone = getCurrentTimeZone()
//
//
//        let headers : HTTPHeaders = [WsHeader.authorization : strAuthToken ,
//                                     WsHeader.accept : WsHeader.applicationJson ,
//                                     WsHeader.contentType : WsHeader.contentTypeData ,
//
//                                     WsHeader.deviceType : "" ,
//                                     WsHeader.deviceTimeZone : currentTimeZone ,
//                                     ]
//        var strCompleteUrl = ""
//
//        if strCustomValidation == WsParamsType.PathVariable{
//            let pathVariable = queryParams.PathString
//            strCompleteUrl = "\(strUrl)" + pathVariable
//            debugPrint("pathVariable...... \(pathVariable)")
//        }else if strCustomValidation == WsParamsType.QueryParams{
//            strCompleteUrl = self.queryString(strUrl, params: queryParams) ?? ""
//        }else{
//            strCompleteUrl = strUrl
//        }
//
//        debugPrint("url..... \(strCompleteUrl)")
//        debugPrint(params ?? [:])
//        debugPrint(headers)
//
//        AF.upload(multipartFormData: { multipartFormData in
//            for (key, value) in params ?? [:]{
//                if key == parameterKey {
//                    // This is problem
//                    for idx in value as! [AnyObject] {
//                        multipartFormData.append("\(idx)".data(using: .utf8)!, withName: "\(key)")
//                    }
//                    debugPrint(multipartFormData)
//                }
//            }
//        }, to: strUrl , usingThreshold: UInt64.init() , method: .post , headers: headers).response{
//            response in
//            switch response.result{
//
//            case .success(_):
//                do{
//                    if let jsonData = response.data{
//                        success(jsonData)
//                    }
//                }
//            case .failure(let encodingError):
//                debugPrint("Error ", encodingError)
//                failure(encodingError)
//            }
//        }
//    }
    
    
}


// MARK: Extension of Dictionary

extension Dictionary{
    
    var queryString : String{
        var outPut : String = ""
        for (key,value) in self{
            outPut += "\(key) = \(value)"
        }
        outPut = String(outPut.dropLast())
        return outPut
    }
    
    var PathString : String{
        var outPut : String = ""
        for (_,value) in self{
            outPut += "\(value)"
        }
        outPut = String(outPut)
        return outPut
    }
    
}


struct WsHeader{
    static let authorization = "authorization"
    static let accept = "accept"
    static let applicationJson = "applicationJson"
    static let contentType = "Content-Type"
    static let contentTypeData = "application/json"
}

struct WsParamsType{
    static let PathVariable = "PathVariable"
    static let QueryParams = "QueryParams"
}
