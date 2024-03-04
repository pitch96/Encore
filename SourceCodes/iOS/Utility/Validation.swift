//
//  Validation.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import Foundation

extension String {

    // To Check Whether Email is valid
   
    func isEmail() -> Bool {
        let emailRegex = "[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]{5}+\\.[A-Za-z]{2,3}" as String
        let emailText = NSPredicate(format: "SELF MATCHES %@",emailRegex)
        let isValid  = emailText.evaluate(with: self) as Bool
        return isValid

    }
    func isCompanyName() -> Bool {
        let emailRegex = "[A-Z0-9a-z._%+-]" as String
        let emailText = NSPredicate(format: "SELF MATCHES %@",emailRegex)
        let isValid  = emailText.evaluate(with: self) as Bool
        return isValid
    }
    func isZipCodeNumber() -> Bool {
        if self.isStringEmpty() {
        return false
        }
        let phoneRegex = "^[0-9]{10}$"
        let phoneText = NSPredicate(format: "SELF MATCHES %@", phoneRegex)
        let isValid = phoneText.evaluate(with: self) as Bool
        return isValid
    }
    // To Check Whether Email is valid
    func isValidString() -> Bool {
        if self == "<null>" || self == "(null)" {
            return false
        }
        return true
    }

    func isValidPassword(text: String) -> Bool {
        let letters = CharacterSet.letters
        let phrase = text
        let range = phrase.rangeOfCharacter(from: letters)
        // range will be nil if no letters is found
        if range != nil {
            return false
        }
        else {
            return true
        }
    }
    // To Check Whether Phone Number is valid
    func isPhoneNumber() -> Bool {
        if self.isStringEmpty() {
            return false
        }
        let phoneRegex = "^\\d{9}$"
        let phoneText = NSPredicate(format: "SELF MATCHES %@", phoneRegex)
        let isValid = phoneText.evaluate(with: self) as Bool
        return isValid
    }
    func isName() -> Bool {
            let fullnameRegex =  "^[A-Z a-z]*$" as String
              let fullnameText = NSPredicate(format: "SELF MATCHES %@",fullnameRegex)
              let isValid  = fullnameText.evaluate(with: self) as Bool
            return isValid
        }
    func isFullName() -> Bool {
        let fullnameRegex =  "^[A-Z]?[a-z]*$" as String
          let fullnameText = NSPredicate(format: "SELF MATCHES %@",fullnameRegex)
          let isValid  = fullnameText.evaluate(with: self) as Bool
        return isValid
    }
    func isNumber() -> Bool {
        if self.isStringEmpty() {
            return false
        }
        let phoneRegex = "^\\d{1,15}$"
        let phoneText = NSPredicate(format: "SELF MATCHES %@", phoneRegex)
        let isValid = phoneText.evaluate(with: self) as Bool
        return isValid
    }
    func isSellingPrice() -> Bool {
        if self.isStringEmpty() {
            return false
        }
        let phoneRegex = "^\\d{1,8}$"
        let phoneText = NSPredicate(format: "SELF MATCHES %@", phoneRegex)
        let isValid = phoneText.evaluate(with: self) as Bool
        return isValid
    }
    // Password_Validation
    func isValidPassword() -> Bool {
                let passwordTest = NSPredicate(format: "SELF MATCHES %@", "^(?=.*[a-z])(?=.*[$@$#!%*?&])[A-Za-z\\d$@$#!%*?&]{8,15}")
                return passwordTest.evaluate(with: self)
            }

    func isValidBANk() -> Bool {
            let ibanRegEx = "^[A-Z]?[a-z]*$"
            let ibanTest = NSPredicate(format:"SELF MATCHES %@", ibanRegEx)
        let isValid = ibanTest.evaluate(with: self) as Bool
            return isValid
        }

   func isValidAccountNum() -> Bool {
    if self.isStringEmpty() {
        return false
    }
    let phoneRegex = "^\\d{8,15}$"
    let phoneText = NSPredicate(format: "SELF MATCHES %@", phoneRegex)
    let isValid = phoneText.evaluate(with: self) as Bool
    return isValid
        }
    func isValidAddress() -> Bool {
        let ibanRegEx =  "^[A-Z a-z]{2,50}"
            let ibanTest = NSPredicate(format:"SELF MATCHES %@", ibanRegEx)
        let isValid = ibanTest.evaluate(with: self) as Bool
            return isValid
        }
    func isStoreAddress() -> Bool {
        let ibanRegEx =  "^[A-Z a-z 0-9]{2,50}"
            let ibanTest = NSPredicate(format:"SELF MATCHES %@", ibanRegEx)
        let isValid = ibanTest.evaluate(with: self) as Bool
            return isValid
        }
    func isValidBankCode() -> Bool {
        let ibanRegEx =  "^[a-zA-Z0-9]{10,15}"
            let ibanTest = NSPredicate(format:"SELF MATCHES %@", ibanRegEx)
        let isValid = ibanTest.evaluate(with: self) as Bool
            return isValid
        }
    func isPasswordValidate() -> Bool {
        let passwordRegix = "^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()\\-_=+{}|?>.<,:;~`’]{8,15}$"
        let passwordText  = NSPredicate(format:"SELF MATCHES %@",passwordRegix)
        return passwordText.evaluate(with:self)
    }

  //  [A-Za-z0-9.@#$%*?:!+-/]{8,25}

    

//    func isPasswordValidate() -> Bool {

//      //  let passwordRegix = "[A-Za-z0-9.@#$%*?:!+-/]{8,15}"

//        let passwordRegix = "^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*()\\-_=+{}|?>.<,:;~`’]{8,15}$"

//        let passwordText  = NSPredicate(format:"SELF MATCHES %@",passwordRegix)

//

//        return passwordText.evaluate(with:self)

//    }

    // To Check Whether URL is valid
    func isURL() -> Bool {
        let urlRegex = "(http|https)://((\\w)*|([0-9]*)|([-|_])*)+([\\.|/]((\\w)*|([0-9]*)|([-|_])*))+" as String
        let urlText = NSPredicate(format: "SELF MATCHES %@", urlRegex)
        let isValid = urlText.evaluate(with: self) as Bool
        return isValid
    }
    // To Check Whether Image URL is valid
    func isImageURL() -> Bool {
        if self.isURL() {
            if self.range(of: ".png") != nil || self.range(of: ".jpg") != nil || self.range(of: ".jpeg") != nil {
                return true
            } else {
                return false
            }
        } else {
            return false
        }
    }
    func toInt() -> Int
    {
        return Int(self) ?? 0
    }
    func trimAll()->String
    {
        return self.trimmingCharacters(in: CharacterSet.whitespacesAndNewlines)
    }
    static func getString(_ message: Any?) -> String {
        guard let strMessage = message as? String else {
            guard let doubleValue = message as? Double else {
                guard let intValue = message as? Int else {
                    guard let int64Value = message as? Int64 else{
                        return ""
                    }
                    return String(int64Value)
                }
                return String(intValue)
            }
            let formatter = NumberFormatter()
            formatter.minimumFractionDigits = 0
            formatter.maximumFractionDigits = 20
            formatter.minimumIntegerDigits = 1
            guard let formattedNumber = formatter.string(from: NSNumber(value: doubleValue)) else {
                
                return ""
            }
            return formattedNumber
        }
        return strMessage.stringByTrimmingWhiteSpaceAndNewLine()
    }
    static func getLength(_ message: Any?) -> Int {
        return String.getString(message).stringByTrimmingWhiteSpaceAndNewLine().count
    }
    static func checkForValidNumericString(_ message: AnyObject?) -> Bool {

        guard let strMessage = message as? String else {
            return true
        }
        if strMessage == "" || strMessage == "0" {
            return true
        }
        return false
    }

    // To Check Whether String is empty
    func isStringEmpty() -> Bool {
        return self.stringByTrimmingWhiteSpace().count == 0 ? true : false

    }
    mutating func removeSubString(subString: String) -> String {
        if self.contains(subString) {
            guard let stringRange = self.range(of: subString) else { return self }
            return self.replacingCharacters(in: stringRange, with: "")
        }
        return self
    }
    // Get string by removing White Space & New Line

    func stringByTrimmingWhiteSpaceAndNewLine() -> String {
        return self.trimmingCharacters(in: NSCharacterSet.whitespacesAndNewlines)

    }
    // Get string by removing White Space
    func stringByTrimmingWhiteSpace() -> String {
        return self.trimmingCharacters(in: NSCharacterSet.whitespaces)

    }
    func getSubStringFrom(begin: NSInteger, to end: NSInteger) -> String {
        // var strRange = begin..<end
        // let str = self.substringWithRange(strRange)
        return ""

    }

}

