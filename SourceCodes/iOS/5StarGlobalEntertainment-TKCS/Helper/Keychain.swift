//
//  Keychain.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 27/04/23.
//

import Foundation
import Security
 
 class KeychainService {
    
    static let sharedInstance = KeychainService()
    
    func save(_ data: Data, key: String) {
           let query = [
               kSecValueData: data,
               kSecAttrAccount: key,
               kSecClass: kSecClassGenericPassword
           ] as CFDictionary
           
           // Add data in query to keychain
           let status = SecItemAdd(query, nil)
           
           if status == errSecDuplicateItem {
               // Item already exist, thus update it.
               let query = [
                
                   kSecAttrAccount: key,
                   kSecClass: kSecClassGenericPassword
               ] as CFDictionary
               
               let attributesToUpdate = [kSecValueData: data] as CFDictionary
               
               // Update existing item
               SecItemUpdate(query, attributesToUpdate)
           }
       }
      // discussion:   Function created to read/fetch user credentials from keychain.
      // parameters:  Key(for fetching the data)
       func read( key: String) -> Data? {
           
           let query = [
               // kSecAttrService: service,
               kSecAttrAccount: key,
               kSecClass: kSecClassGenericPassword,
               kSecReturnData: true
           ] as CFDictionary
           
           var result: AnyObject?
           SecItemCopyMatching(query, &result)
           return (result as? Data)
       }
        // discussion:    Function created to delete user credentials from keychain.
        // parameters: Key(for deleting the data)
       func delete(key: String) {
           
           let query = [
               // kSecAttrService: service,
               kSecAttrAccount: key,
               kSecClass: kSecClassGenericPassword
           ] as CFDictionary
           
           // Delete item from keychain
           SecItemDelete(query)
       }
   }
    
 
extension KeychainService {
    // discussion:  Generic Function created to save user credentials in keychain.
    // parameters:item(userdata),  Key(for fetching the data)
    func save<T>(_ item: T, key: String) where T: Codable {
        do {
            // Encode as JSON data and save in keychain
            let data = try JSONEncoder().encode(item)
            save(data, key: key)
            
        } catch {
            assertionFailure("Fail to encode item for keychain: \(error)")
        }
    }
    
    // discussion:   Generic Function created to read/fetch user credentials from keychain.
     // parameters: Key(for fetching the data), type(type of data to fetch[string/int/bool])
    func read<T>(key: String, type: T.Type) -> T? where T: Codable {
        
        // Read item data from keychain
        guard let data = read(key: key) else {
            return nil
        }
        
        // Decode JSON data to object
        do {
            let item = try JSONDecoder().decode(type, from: data)
            return item
        } catch {
            assertionFailure("Fail to decode item for keychain: \(error)")
            return nil
        }
    }
}
