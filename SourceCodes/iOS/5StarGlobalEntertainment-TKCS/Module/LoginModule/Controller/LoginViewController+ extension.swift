//
//  LoginViewController+ extension.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 27/04/23.
//

import Foundation
import LocalAuthentication
extension LoginViewController {
//    extension LoginViewController {
        // MARK: - FACE-ID Authentication
            /// function to authenicate face
            /// store the condition in Keychain
            func authenticate() {
                let context = LAContext()
                var error: NSError?
                let biometricsPolicy = LAPolicy.deviceOwnerAuthenticationWithBiometrics

                if context.canEvaluatePolicy(.deviceOwnerAuthenticationWithBiometrics, error: &error) {

                    var reason = Biometric.reason
                    switch context.biometryType {
                    case .faceID: reason = Biometric.FaceId
                    case .touchID: reason = Biometric.TouchId
                    case .none: debugPrint(Biometric.None)

                    @unknown default:
                        fatalError()
                    }

                    context.evaluatePolicy(biometricsPolicy, localizedReason: reason) { isSuccess, _ in
                        DispatchQueue.main.async {
                            guard isSuccess, error == nil else {
                                //  Authentication failed, prompt an error message to the user
                                return
                            }
                            if isSuccess {
                               
                                let email = KeychainService.sharedInstance.read(key: Tokenkey.email, type: String.self)
                                let password = KeychainService.sharedInstance.read(key: Tokenkey.password, type: String.self)
//                                self.viewModel.callLogInUpApi(email: email ?? "", password: password ?? "", complition: void)
//                                self.loginViewModel.callLogin(emailText: email ?? "", passwordField: password ?? "", view: self)


                            } else {
                            }
                            // Authentication successful! Proceed to next app screen.
                            //debugPrint(Constant.Succesful)
                        }
                    }
                } else {
                    // No biometrics available
    //                Common.sharedInstance.alert(view: self, title: "Face ID unavailable", message: "No face ID unavailable")
                }
            }

    }

//}
