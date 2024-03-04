////
////  NetworkManager.swift
////  5StarGlobalEntertainment-TKCS
////
////  Created by chetu on 21/11/22.
////
//
//import Foundation
////import Reachability
//
//
//class NetworkManager: NSObject {
//    var reachability: Reachability!
//    
//    static let sharedInstance: NetworkManager = {
//        return NetworkManager()
//        
//    }()
//
//    override init(){
//        super.init()
//        
//        reachability = try! Reachability()
//        NotificationCenter.default.addObserver(self, selector: #selector(reachabilityChanged), name: .reachabilityChanged, object: reachability)
//        do {
//            try reachability.startNotifier()
//        } catch{
//            print("Unable to start notifier")
//        }
//    }
//    
//    @objc func reachabilityChanged(note: Notification) {
//        
//        let reachability = note.object as! Reachability
//        
//        switch reachability.connection {
//        case .wifi:
//            print("Reachable via WiFi")
//        case .cellular:
//            print("Reachable via Cellular")
//        case .unavailable:
//            print("Network not reachable")
//        case .none:
//            print("Network not avalible")
//        }
//    }
//
//    
//    static func stopNotifier() -> Void {
//        do {
//            try (NetworkManager.sharedInstance.reachability).startNotifier()
//            
//        } catch {
//            print("Error stopping notifier")
//            
//        }
//        
//    }
//    static func isReachable(completed: @escaping (NetworkManager) -> Void) {
//        if (NetworkManager.sharedInstance.reachability).connection != .none {
//            completed(NetworkManager.sharedInstance)
//            
//        }
//        
//    }
//    static func isUnreachable(completed: @escaping (NetworkManager) -> Void) {
//        if (NetworkManager.sharedInstance.reachability).connection == .none {
//            completed(NetworkManager.sharedInstance)
//            
//        }
//        
//    }
//    static func isReachableViaWWAN(completed: @escaping (NetworkManager) -> Void) {
//        if (NetworkManager.sharedInstance.reachability).connection == .cellular {
//            completed(NetworkManager.sharedInstance)
//            
//        }
//        
//    }
//    static func isReachableViaWiFi(completed: @escaping (NetworkManager) -> Void) {
//        if (NetworkManager.sharedInstance.reachability).connection == .wifi {
//            completed(NetworkManager.sharedInstance)
//        }
//        
//    }
//    }
//
